<?php

namespace App\Http\Controllers;

use App\Notifications\VerifyEmailNotification;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\MailHelper;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Check database connection with custom error message
     */
    private function checkDatabaseConnection()
    {
        try {
            DB::connection()->getPdo();
            return true;
        } catch (\Exception $e) {
            Log::error('Database connection failed', [
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
            return false;
        }
    }

    /**
     * Show sign in page
     */
    public function showSignIn()
    {
        return view('auth.sign-in');
    }

    /**
     * Handle sign in request
     */
    public function signIn(Request $request)
    {
        // First check database connection
        if (!$this->checkDatabaseConnection()) {
            return back()->withErrors([
                'database' => 'Unable to connect to the database. Please make sure XAMPP/WAMP is running and MySQL is started.'
            ])->withInput();
        }
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'remember' => ['nullable', 'boolean']
        ]);

        // First check if user exists
        try {
            $user = User::where('email', $credentials['email'])->first();
        } catch (\Exception $e) {
            Log::error('Database query failed', [
                'error' => $e->getMessage(),
                'email' => $credentials['email']
            ]);
            
            return back()->withErrors([
                'database' => 'Database connection error. Please check if MySQL is running in XAMPP/WAMP.'
            ])->withInput();
        }
        
        // If user exists but email is not verified
        if ($user && !$user->hasVerifiedEmail()) {
            Log::warning('Login attempt by unverified user', [
                'email' => $credentials['email'],
                'user_id' => $user->id
            ]);
            
            // Redirect to verification notice page with email
            return redirect()->route('verification.notice', ['email' => $user->email])
                ->with('info', 'Please verify your email address before logging in. Check your inbox for the verification link.');
        }

        // Attempt to log in
        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ], $request->boolean('remember'))) {
            
            $request->session()->regenerate();
            
            // Get the authenticated user
            $user = Auth::user();
            
            // Double-check verification (extra safety)
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                return redirect()->route('verification.notice', ['email' => $user->email])
                    ->with('info', 'Please verify your email address before logging in.');
            }
            
            // Log successful login
            Log::info('User logged in successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'user_type' => $user->user_type
            ]);
            
            // Redirect based on user_type
            return $this->redirectToDashboard($user);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Redirect user to appropriate dashboard based on user_type
     */
    private function redirectToDashboard($user)
    {
        switch ($user->user_type) {
            case 'admin':
                return redirect()->route('admin.dashboard');
                
            case 'tech':
                return redirect()->route('tech.dashboard');
                
            case 'user':
            default:
                return redirect()->route('dashboard');
        }
    }

    /**
     * Show sign up page
     */
    public function showSignUp()
    {
        return view('auth.sign-up');
    }

 /**
 * Handle sign up request
 */
public function signUp(Request $request)
{
    // Check database connection first
    if (!$this->checkDatabaseConnection()) {
        return redirect()->back()
            ->withErrors(['database' => '⚠️ Database connection failed. Please make sure XAMPP/WAMP is running and MySQL is started.'])
            ->withInput();
    }
    
    Log::info('signUp method called', ['request_data' => $request->except('password', 'password_confirmation')]);
    
    try {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'company' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted'
        ]);

        Log::info('Validation passed', ['email' => $validated['email']]);

        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'company' => $validated['company'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'user_type' => 'user',
            'email_verified_at' => null,
        ]);

        Log::info('User created', ['user_id' => $user->id, 'email' => $user->email]);

        // Send verification email
        try {
            // Log before sending
            Log::info('Attempting to send verification email', [
                'to' => $user->email,
                'notification_class' => 'VerifyEmailNotification'
            ]);
            
            // Send the notification
            $user->notify(new \App\Notifications\VerifyEmailNotification($user));
            
            Log::info('Verification email sent successfully', [
                'to' => $user->email,
                'expires_in' => config('auth.verification.expire', 2) . ' minutes'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to send verification email', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'to' => $user->email
            ]);
        }

        return redirect()->route('verification.notice', ['email' => $user->email])
            ->with('success', 'Registration successful! Please check your email to activate your account.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::warning('Validation failed', ['errors' => $e->errors()]);
        return redirect()->back()
            ->withErrors($e->validator)
            ->withInput();
            
    } catch (\Illuminate\Database\QueryException $e) {
        Log::error('Database error during registration', [
            'error' => $e->getMessage(),
            'code' => $e->getCode()
        ]);
        
        return redirect()->back()
            ->withErrors(['database' => 'Database connection error. Please check if MySQL is running in XAMPP/WAMP.'])
            ->withInput();
                
    } catch (\Exception $e) {
        Log::error('Registration failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return redirect()->back()
            ->with('error', 'Registration failed: ' . $e->getMessage())
            ->withInput();
    }
}

    /**
     * Resend welcome email
     */
    public function resendWelcomeEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        try {
            Mail::to($user->email)->send(new WelcomeMail($user));
            
            return response()->json([
                'success' => true,
                'message' => 'Welcome email resent successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to resend email'
            ], 500);
        }
    }

    /**
     * Handle technician account creation (Admin only)
     */
    public function createTechAccount(Request $request)
    {
        if (auth()->user()->user_type !== 'admin') {
            abort(403, 'Unauthorized access. Admin only.');
        }
        
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'company' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'tech',
            'company' => $request->company,
            'phone' => $request->phone,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Technician account created successfully!');
    }

    /**
     * Handle sign out
     */
    public function signOut(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
        $request->session()->regenerateToken();
 
        return redirect('/')->with('success', 'You have been signed out.');
    }

    /**
     * Show forgot password page
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle forgot password request - USING CUSTOM reset_password_token
     */
    public function forgotPassword(Request $request)
    {
        // Check database connection first
        if (!$this->checkDatabaseConnection()) {
            return back()->withErrors([
                'database' => 'Unable to connect to the database. Please make sure XAMPP/WAMP is running and MySQL is started.'
            ])->withInput();
        }
        
        // Validate email
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Find the user
        try {
            $user = User::where('email', $request->email)->first();
        } catch (\Exception $e) {
            Log::error('Database query failed in forgot password', [
                'error' => $e->getMessage(),
                'email' => $request->email
            ]);
            
            return back()->withErrors([
                'database' => 'Database connection error. Please check if MySQL is running in XAMPP/WAMP.'
            ])->withInput();
        }

        // Generate a unique token
        $token = Str::random(64);
        
        // Save token to user record using YOUR custom columns
        $user->reset_password_token = $token;
        $user->reset_password_expires = Carbon::now()->addHours(24);
        $user->save();

        // Send email with reset link
        try {
            $this->sendResetEmail($user, $token);
            
            return back()->with('success', 'Password reset link has been sent to your email!');
        } catch (\Exception $e) {
            // Log the full error details
            Log::error('Password reset email failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_email' => $user->email
            ]);
            
            return back()->withErrors(['email' => 'Failed to send email. Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Send reset password email
     */
    private function sendResetEmail($user, $token)
    {
        // Create reset link
        $resetLink = route('password.reset', [
            'token' => $token, 
            'email' => $user->email
        ]);
        
        // Get user's IP and browser info for security
        $ipAddress = request()->ip();
        $userAgent = request()->userAgent();
        
        // Prepare email data
        $data = [
            'user' => $user,
            'resetLink' => $resetLink,
            'expires' => Carbon::now()->addHours(24)->format('F j, Y \a\t g:i A'),
            'ipAddress' => $ipAddress,
            'userAgent' => $userAgent,
            'year' => date('Y')
        ];
        
        // Send email using default mailer (which is your Outlook config)
        Mail::send('email.reset-password', $data, function ($message) use ($user) {
            $message->to($user->email, $user->name)
                    ->subject('Reset Your Password - Dataworld Support');
            $message->from(
                config('mail.from.address'), // This is ticket-support@dataworld.com.ph
                config('mail.from.name')      // This is "Dataworld Support"
            );
            $message->replyTo('ticket-support@dataworld.com.ph', 'Dataworld Support');
        });
    }

    /**
     * Show reset password form (when user clicks the email link)
     */
    public function showResetPassword($token)
    {
        // Check database connection first
        if (!$this->checkDatabaseConnection()) {
            return redirect()->route('forgot-password')
                ->withErrors(['database' => 'Database connection error. Please check if MySQL is running in XAMPP/WAMP.']);
        }
        
        // Find user with this token and check if not expired
        $user = User::where('reset_password_token', $token)
                    ->where('reset_password_expires', '>', Carbon::now())
                    ->first();

        if (!$user) {
            return redirect()->route('forgot-password')
                ->withErrors(['email' => 'Invalid or expired password reset link. Please request a new one.']);
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $user->email
        ]);
    }

    /**
     * Handle password reset
     */
    public function resetPassword(Request $request)
    {
        // Check database connection first
        if (!$this->checkDatabaseConnection()) {
            return back()->withErrors([
                'database' => 'Unable to connect to the database. Please make sure XAMPP/WAMP is running and MySQL is started.'
            ])->withInput();
        }
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Find user with valid token using YOUR custom columns
        $user = User::where('email', $request->email)
                    ->where('reset_password_token', $request->token)
                    ->where('reset_password_expires', '>', Carbon::now())
                    ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Invalid or expired password reset link.']);
        }

        // Update password
        $user->password = Hash::make($request->password);
        
        // Clear the reset token fields
        $user->reset_password_token = null;
        $user->reset_password_expires = null;
        $user->save();

        return redirect()->route('sign-in')
            ->with('success', 'Your password has been reset successfully! You can now sign in.');
    }

    /**
     * =============================================
     * DASHBOARD METHODS
     * =============================================
     */

    /**
     * Show dashboard based on user type
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        switch ($user->user_type) {
            case 'admin':
                return $this->adminDashboard();
            case 'tech':
                return $this->techDashboard();
            case 'user':
            default:
                return $this->userDashboard();
        }
    }

    /**
     * Show regular user dashboard
     */
    public function userDashboard()
    {
        $user = Auth::user();
        
        // Get recent tickets for this user (limit 5)
        $recentTickets = Ticket::with(['category', 'assignedTech'])
            ->where('created_by', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get ticket statistics
        $activeTickets = Ticket::where('created_by', $user->id)
            ->whereIn('status', ['pending', 'open', 'in_progress'])
            ->count();
            
        $awaitingResponse = Ticket::where('created_by', $user->id)
            ->whereIn('status', ['pending', 'open'])
            ->whereNotNull('assigned_to')
            ->count();
            
        $resolvedThisMonth = Ticket::where('created_by', $user->id)
            ->whereIn('status', ['resolved', 'closed'])
            ->whereMonth('resolved_at', now()->month)
            ->count();
            
        $totalTickets = Ticket::where('created_by', $user->id)->count();
        
        $ticketStats = [
            'active' => $activeTickets,
            'awaiting' => $awaitingResponse,
            'resolved' => $resolvedThisMonth,
            'total' => $totalTickets,
        ];
        
        // Get all tickets for pagination
        $allTickets = Ticket::where('created_by', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('dashboard', compact('recentTickets', 'allTickets', 'ticketStats'));
    }

    /**
     * Delete expired unverified users
     */
    public function deleteExpiredUnverifiedUsers()
    {
        try {
            $expireMinutes = 2;
            $cutoffTime = now()->subMinutes($expireMinutes);
            
            echo "🔍 Current time: " . now()->format('Y-m-d H:i:s') . "\n";
            echo "🔍 Cutoff time (2 mins ago): " . $cutoffTime->format('Y-m-d H:i:s') . "\n";
            echo "----------------------------------------\n";
            
            // Find users to delete based on criteria:
            // - user_type = 'user'
            // - email_verified_at IS NULL
            // - created_at <= 2 minutes ago
            $usersToDelete = User::where('user_type', 'user')
                ->whereNull('email_verified_at')
                ->where('created_at', '<=', $cutoffTime)
                ->get();
            
            $deletedCount = 0;
            $deletedEmails = [];
            $deletedIds = [];
            
            if ($usersToDelete->count() > 0) {
                echo "📊 Found " . $usersToDelete->count() . " users to delete:\n";
                
                foreach ($usersToDelete as $user) {
                    // Calculate age in minutes
                    $ageMinutes = now()->diffInMinutes($user->created_at);
                    
                    echo "   - ID: {$user->id}, Email: {$user->email}, Created: {$user->created_at} ({$ageMinutes} minutes old)\n";
                    
                    // Store info before deletion
                    $deletedEmails[] = $user->email;
                    $deletedIds[] = $user->id;
                    
                    // Log before deletion
                    Log::info('🗑️ Deleting expired unverified user', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'user_type' => $user->user_type,
                        'registered_at' => $user->created_at->format('Y-m-d H:i:s'),
                        'age_minutes' => $ageMinutes,
                        'deleted_at' => now()->format('Y-m-d H:i:s')
                    ]);
                    
                    // Delete the user
                    $user->delete();
                    $deletedCount++;
                }
                
                echo "✅ Deleted {$deletedCount} expired unverified users\n";
                if (count($deletedEmails) > 0) {
                    echo "📧 Deleted emails: " . implode(', ', $deletedEmails) . "\n";
                }
                
                // Log summary
                Log::info("✅ Cleanup completed", [
                    'deleted_count' => $deletedCount,
                    'deleted_ids' => $deletedIds,
                    'deleted_emails' => $deletedEmails,
                    'cutoff_time' => $cutoffTime->format('Y-m-d H:i:s')
                ]);
                
            } else {
                echo "✅ No expired unverified users found to delete\n";
                
                // Show users that will be deleted soon
                $soonToDelete = User::where('user_type', 'user')
                    ->whereNull('email_verified_at')
                    ->where('created_at', '>', $cutoffTime)
                    ->where('created_at', '<=', now())
                    ->orderBy('created_at', 'asc')
                    ->get();
                    
                if ($soonToDelete->count() > 0) {
                    echo "⏳ Users that will be deleted soon:\n";
                    foreach ($soonToDelete as $user) {
                        $minutesOld = now()->diffInMinutes($user->created_at);
                        $minutesLeft = $expireMinutes - $minutesOld;
                        $deleteTime = $user->created_at->addMinutes($expireMinutes);
                        
                        echo "   - {$user->email} (created {$minutesOld} min ago, will delete at {$deleteTime->format('H:i:s')} in ~{$minutesLeft} min)\n";
                    }
                }
            }
            
            return $deletedCount;
            
        } catch (\Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "\n";
            Log::error('❌ Cleanup failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 0;
        }
    }

    /**
     * Show admin dashboard
     */
    public function adminDashboard()
    {
        $user = Auth::user();
        
        // Only admins can access this
        if ($user->user_type !== 'admin') {
            abort(403, 'Unauthorized access. Admin only.');
        }
        
        // Get recent tickets (limit 5)
        $recentTickets = Ticket::with(['category', 'creator', 'assignedTech'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get all tickets for full view
        $allTickets = Ticket::with(['category', 'creator', 'assignedTech'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Get technicians
        $technicians = User::where('user_type', 'tech')->get();
        
        // Get ticket statistics
        $ticketStats = [
            'active' => Ticket::whereIn('status', ['pending', 'open', 'in_progress'])->count(),
            'unassigned' => Ticket::whereNull('assigned_to')->count(),
            'resolved' => Ticket::whereIn('status', ['resolved', 'closed'])->count(),
            'total' => Ticket::count(),
            'high_priority' => Ticket::where('priority', 'high')->count(),
        ];
        
        return view('admin.dashboard', compact('recentTickets', 'allTickets', 'technicians', 'ticketStats'));
    }

    /**
     * Show tech dashboard
     */
    public function techDashboard()
    {
        $user = Auth::user();
        
        // Only techs can access this
        if ($user->user_type !== 'tech') {
            abort(403, 'Unauthorized access. Tech only.');
        }
        
        // Get recent tickets assigned to this tech (limit 5)
        $recentTickets = Ticket::with(['category', 'creator'])
            ->where('assigned_to', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get all tickets for full view
        $allTickets = Ticket::with(['category', 'creator'])
            ->where('assigned_to', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $ticketStats = [
            'active' => Ticket::where('assigned_to', $user->id)
                ->whereIn('status', ['pending', 'open', 'in_progress'])
                ->count(),
            'resolved' => Ticket::where('assigned_to', $user->id)
                ->whereIn('status', ['resolved', 'closed'])
                ->count(),
            'total' => Ticket::where('assigned_to', $user->id)->count(),
            'high_priority' => Ticket::where('assigned_to', $user->id)
                ->where('priority', 'high')
                ->count(),
        ];
        
        return view('tech.dashboard', compact('recentTickets', 'allTickets', 'ticketStats'));
    }

 /**
     * Show user profile dashboard
     */
    public function profileDashboard()
    {
        $user = Auth::user();
        
        // Get user statistics
        $totalTickets = Ticket::where('created_by', $user->id)->count();
        $activeTickets = Ticket::where('created_by', $user->id)
            ->whereIn('status', ['pending', 'open', 'in_progress'])
            ->count();
        $resolvedTickets = Ticket::where('created_by', $user->id)
            ->whereIn('status', ['resolved', 'closed'])
            ->count();
        
        // Get recent activities
        $recentActivities = Ticket::where('created_by', $user->id)
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($ticket) {
                return (object) [
                    'type' => 'ticket',
                    'description' => 'Ticket #' . $ticket->ticket_number,
                    'details' => $ticket->subject,
                    'status' => $ticket->status,
                    'created_at' => $ticket->updated_at
                ];
            });
        
        return view('profile.dashboard', compact(
            'user',
            'totalTickets',
            'activeTickets',
            'resolvedTickets',
            'recentActivities'
        ));
    }

    /**
     * Show edit profile form
     */
    public function editProfile()
    {
        $user = Auth::user();
        
        // Debug - check if user data exists (remove after fixing)
        if (!$user) {
            dd('No authenticated user found');
        }
        
        return view('profile.edit', compact('user'));
    }

    /**
     * Update profile information
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'company' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->company = $request->company;
        $user->phone = $request->phone;

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('profile.dashboard')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Show change password form
     */
    public function showPasswordForm()
    {
        $user = Auth::user();
        return view('profile.password', compact('user'));
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed', Password::defaults()],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        // Check if current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'The current password is incorrect.'])
                ->withInput();
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile.dashboard')
            ->with('success', 'Password changed successfully.');
    }

    /**
     * Delete account
     */
    public function destroyProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        // Check password
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withErrors(['password' => 'The password is incorrect.'])
                ->withInput();
        }

        // Check if user has tickets
        $ticketCount = Ticket::where('created_by', $user->id)->count();
        if ($ticketCount > 0) {
            return redirect()->back()
                ->withErrors(['account' => 'Cannot delete account with existing tickets. Please contact support.'])
                ->withInput();
        }

        // Logout user
        Auth::logout();

        // Delete user
        $user->delete();

        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Your account has been deleted successfully.');
    }
}

