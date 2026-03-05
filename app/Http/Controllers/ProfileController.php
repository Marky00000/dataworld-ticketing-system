<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Carbon\Carbon;
use App\Helpers\MailHelper;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;


class ProfileController extends Controller
{
    /**
     * Show user profile dashboard
     */
    public function dashboard()
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

      public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }
    

    public function update(Request $request)
{
    $user = Auth::user();
    
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'phone' => 'nullable|string|max:20',
        'company' => 'nullable|string|max:255',
        'job_title' => 'nullable|string|max:255',
        'department' => 'nullable|string|max:255',
        'bio' => 'nullable|string|max:500',
        'timezone' => 'nullable|string|max:50',
        'language' => 'nullable|string|max:10',
    ]);
    
    $user->update($validated);
    
    return redirect()->route('profile.edit')
        ->with('success', 'Profile updated successfully!');
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
    $validated = $request->validate([
        'current_password' => ['required', 'current_password'],
        'new_password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);
    
    try {
        $user = Auth::user();
        
        // Update password
        $user->password = Hash::make($validated['new_password']);
        $user->save();
        
        // Log the password change
        Log::info('Password changed successfully for user: ' . $user->email . ' from IP: ' . $request->ip());
        
        // Return success message without email
        return back()->with('success', 'Password changed successfully!');
        
    } catch (\Exception $e) {
        Log::error('Password change failed for user ' . Auth::user()->email . ': ' . $e->getMessage());
        return back()->with('error', 'Failed to change password. Please try again.');
    }
}

    /**
     * Delete account
     */
    public function destroy(Request $request)
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
                ->withErrors(['password' => 'The current password is incorrect.'])
                ->withInput();
        }

        // Check if user has tickets (optional)
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

        Log::info('Account deleted successfully', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);

        return redirect('/')
            ->with('success', 'Your account has been deleted successfully.');
    }
}