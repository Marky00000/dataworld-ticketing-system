<?php
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use Illuminate\Foundation\Application;
use App\Helpers\MailHelper;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;

// Guest routes (accessible only when NOT authenticated)
Route::middleware('guest')->group(function () {

    Route::get('/login', function() {
        return redirect()->route('sign-in');
    })->name('login');
    
    // Landing page
    Route::get('/', function () {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('sign-in'),
            'canRegister' => Route::has('sign-up'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION
        ]);
    });
    
    // Auth Routes
    Route::get('/sign-in', [AuthController::class, 'showSignIn'])->name('sign-in');
    Route::post('/sign-in', [AuthController::class, 'signIn'])->name('sign-in.post');
    Route::get('/sign-up', [AuthController::class, 'showSignUp'])->name('sign-up');
    Route::post('/sign-up', [AuthController::class, 'signUp'])->name('sign-up.post');
    
    Route::get('/cleanup-users', [AuthController::class, 'cleanupExpiredUsers']);
    Route::get('/delete-unverified', [AuthController::class, 'deleteUnverifiedUserAccounts']);

    // Password reset routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password.post');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('reset-password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password.post');
});

// Sign out route (accessible when authenticated)
Route::post('/sign-out', [AuthController::class, 'signOut'])->name('sign-out')->middleware('auth');

// ============== PROTECTED ROUTES (require authentication) ==============

// Protected routes - All authenticated users
Route::middleware(['auth'])->group(function () {
    // Main dashboard router
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
});

// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('dashboard');
    
    // Create Tech Account
    Route::get('/create_tech', function () {
        $user = auth()->user();
        if ($user->user_type !== 'admin') {
            abort(403, 'Unauthorized access. Admin only.');
        }
        return view('admin.create_tech');
    })->name('tech.create');
    
    Route::post('/tech', [AuthController::class, 'createTechAccount'])->name('tech.store');
    
    // Ticket Categories Management
    Route::get('/ticket-categories', [TicketController::class, 'categoriesIndex'])->name('ticket-categories');
    Route::get('/ticket-categories/create', [TicketController::class, 'categoriesCreate'])->name('ticket-categories.create');
    Route::post('/ticket-categories', [TicketController::class, 'categoriesStore'])->name('ticket-categories.store');
    Route::get('/ticket-categories/{id}/edit', [TicketController::class, 'categoriesEdit'])->name('ticket-categories.edit');
    Route::put('/ticket-categories/{id}', [TicketController::class, 'categoriesUpdate'])->name('ticket-categories.update');
    Route::delete('/ticket-categories/{id}', [TicketController::class, 'categoriesDestroy'])->name('ticket-categories.destroy');
});

// Tech routes
Route::middleware(['auth'])->prefix('tech')->name('tech.')->group(function () {
    // Tech Dashboard
    Route::get('/dashboard', [AuthController::class, 'techDashboard'])->name('dashboard');
});

// Profile routes for all authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/dashboard', [ProfileController::class, 'dashboard'])->name('profile.dashboard');
});

// Ticket routes
Route::middleware(['auth'])->group(function () {
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
    Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    Route::get('/tickets/my_tickets_view/{id}', [TicketController::class, 'myTicketsView'])->name('tickets.my_tickets_view');
    Route::post('/tickets/{id}/assign', [TicketController::class, 'assign'])->name('tickets.assign');
});

Route::middleware(['auth'])->group(function () {
    
    // Conversation Dashboard
    Route::get('/conversation/dashboard', [ConversationController::class, 'dashboard'])
        ->name('conversation.dashboard');
    
    // View Ticket Conversation
    Route::get('/conversation/ticket_update/{id}', [ConversationController::class, 'ticketUpdate'])
        ->name('conversation.ticket_update');
    
    // Store new message
    Route::post('/conversation/ticket/{id}/message', [ConversationController::class, 'storeMessage'])
        ->name('conversation.store-message');
    
    // Get new messages (for polling)
    Route::get('/conversation/ticket/{id}/messages', [ConversationController::class, 'getNewMessages'])
        ->name('conversation.new-messages');
    
        
});


// ============== API ROUTES (accessible to authenticated users) ==============
Route::middleware(['auth'])->group(function () {
    // Get tech users - USING CONTROLLER
    Route::get('/api/users/tech', [App\Http\Controllers\UserController::class, 'getTechUsers'])
        ->name('api.users.tech');

    // Assign ticket
    Route::post('/tickets/{id}/assign', function($id, Request $request) {
        try {
            $ticket = Ticket::findOrFail($id);
            $ticket->assigned_to = $request->tech_id;
            $ticket->status = 'in_progress';
            $ticket->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Ticket assigned successfully',
                'ticket' => $ticket->load('assignedTech')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error assigning ticket: ' . $e->getMessage()
            ], 500);
        }
    })->name('tickets.assign');
});

// TEMPORARY TEST ROUTE - Add this at the BOTTOM of your web.php
Route::get('/api/test-tech-direct', function() {
    try {
        $techs = App\Models\User::where('user_type', 'tech')
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'phone']);
        
        return response()->json([
            'success' => true,
            'data' => $techs,
            'count' => $techs->count()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
});


// routes/web.php
Route::get('/test-exchange-smtp', function() {
    try {
        Mail::raw('Test from Laravel via Exchange SMTP!', function ($message) {
            $message->to('your-email@dataworld.com.ph')
                    ->subject('Exchange SMTP Test');
        });
        return 'SMTP working!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

// Test route (remove after testing)
Route::get('/test-tech-users', function() {
    $techs = User::where('user_type', 'tech')
        ->where('is_active', true)
        ->get(['id', 'name', 'email', 'phone']);
    
    return response()->json([
        'success' => true,
        'data' => $techs,
        'count' => $techs->count()
    ]);
});


Route::post('/resend-welcome-email', [AuthController::class, 'resendWelcomeEmail'])->name('resend.welcome.email');
Route::get('/test-send/{email}', function($email) {
    try {
        // Create a test user object
        $testUser = new \stdClass();
        $testUser->name = 'Test User';
        $testUser->email = $email;
        $testUser->company = 'Test Company';
        $testUser->phone = '1234567890';
        $testUser->created_at = now();
        
        // Create a real user if you want
        $user = App\Models\User::where('email', $email)->first();
        if (!$user) {
            return "User not found: " . $email;
        }
        
        Mail::to($email)->send(new WelcomeMail($user));
        
        return [
            'success' => true,
            'message' => 'Email sent to ' . $email,
            'from' => config('mail.from.address'),
            'mailer' => config('mail.default')
        ];
    } catch (\Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ];
    }
});


Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->name('verification.verify');

Route::get('/email/verify-notice', [VerificationController::class, 'notice'])
    ->name('verification.notice');

Route::get('/email/verification-expired', [VerificationController::class, 'expired'])
    ->name('verification.expired');

Route::post('/email/verification-resend', [VerificationController::class, 'resend'])
    ->name('verification.resend');


Route::get('/test-detection/{email}', function($email) {
    $detectedMailer = MailHelper::getMailerForEmail($email);
    $domain = MailHelper::getDomain($email);
    
    // Check mailer status
    $outlookStatus = MailHelper::checkMailerStatus('outlook');
    $gmailStatus = MailHelper::checkMailerStatus('gmail');
    
    return response()->json([
        'email' => $email,
        'domain' => $domain,
        'detected_mailer' => $detectedMailer,
        'mailer_status' => [
            'outlook' => $outlookStatus,
            'gmail' => $gmailStatus
        ],
        'config' => [
            'outlook_host' => env('OUTLOOK_HOST'),
            'gmail_username' => env('GMAIL_USERNAME') ? 'set' : 'not set',
        ]
    ]);
});


