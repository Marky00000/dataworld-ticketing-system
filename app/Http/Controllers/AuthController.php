<?php

namespace App\Http\Controllers;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\MailHelper;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
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
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'remember' => ['nullable', 'boolean']
        ]);

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // Get the authenticated user
            $user = Auth::user();
            
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

public function signUp(Request $request)
{
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
     * Handle forgot password request
     */
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show reset password page
     */
    public function showResetPassword(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Handle reset password request
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('sign-in')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
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

      
       
        public function deleteExpiredUnverifiedUsers()
        {
            try {
                $expireMinutes = 2;
                $cutoffTime = now()->subMinutes($expireMinutes);
                
                Log::info('🔍 Running cleanup for expired unverified users', [
                    'current_time' => now()->format('Y-m-d H:i:s'),
                    'cutoff_time' => $cutoffTime->format('Y-m-d H:i:s'),
                    'delete_users_older_than' => $expireMinutes . ' minutes'
                ]);
                
                $usersToDelete = User::where('user_type', User::USER_TYPE_USER)
                    ->whereNull('email_verified_at')
                    ->where('created_at', '<=', $cutoffTime)
                    ->whereDoesntHave('createdTickets') 
                    ->get();
                
                $deletedCount = 0;
                $deletedEmails = [];
                $deletedIds = [];
                
                foreach ($usersToDelete as $user) {
                    // Log each deletion
                    Log::info('🗑️ Deleting expired unverified user', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'user_type' => $user->user_type,
                        'registered_at' => $user->created_at->format('Y-m-d H:i:s'),
                        'age_minutes' => now()->diffInMinutes($user->created_at),
                        'deleted_at' => now()->format('Y-m-d H:i:s')
                    ]);
                    
                    $deletedEmails[] = $user->email;
                    $deletedIds[] = $user->id;
                    
                    // Delete the user
                    $user->delete();
                    $deletedCount++;
                }
                
                $skippedUsers = User::where('user_type', User::USER_TYPE_USER)
                    ->whereNull('email_verified_at')
                    ->where('created_at', '<=', $cutoffTime)
                    ->whereHas('createdTickets')
                    ->withCount('createdTickets')
                    ->get(['id', 'email']);
                
                // Log summary
                if ($deletedCount > 0) {
                    Log::info("✅ Cleanup completed", [
                        'deleted_count' => $deletedCount,
                        'deleted_ids' => $deletedIds,
                        'deleted_emails' => $deletedEmails,
                        'cutoff_time' => $cutoffTime->format('Y-m-d H:i:s')
                    ]);
                    
                    echo "✅ Deleted {$deletedCount} expired unverified users (2+ minutes old, no tickets)\n";
                    if (count($deletedEmails) > 0) {
                        echo "📧 Deleted emails: " . implode(', ', $deletedEmails) . "\n";
                    }
                } else {
                    echo "✅ No expired unverified users found to delete\n";
                }
                
                if ($skippedUsers->count() > 0) {
                    echo "⚠️ Skipped {$skippedUsers->count()} users with tickets:\n";
                    foreach ($skippedUsers as $user) {
                        echo "   - {$user->email} (has {$user->created_tickets_count} ticket(s))\n";
                    }
                    
                    Log::info("⚠️ Skipped users with tickets", [
                        'skipped_count' => $skippedUsers->count(),
                        'skipped_emails' => $skippedUsers->pluck('email')->toArray()
                    ]);
                }
                
                return $deletedCount;
                
            } catch (\Exception $e) {
                Log::error('❌ Cleanup failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                echo "❌ Error: " . $e->getMessage() . "\n";
                return 0;
            }
        }

    
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
}