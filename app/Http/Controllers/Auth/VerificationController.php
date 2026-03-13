<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    /**
     * Verify email - NO EXPIRATION, just verify immediately
     */
    public function verify(Request $request, $id, $hash)
    {
        // Log for debugging
        \Log::info('=== VERIFICATION ATTEMPT ===', [
            'user_id' => $id,
            'hash' => $hash,
            'full_url' => $request->fullUrl(),
            'timestamp' => now()->format('Y-m-d H:i:s')
        ]);

        // Find the user
        $user = User::find($id);

        if (!$user) {
            \Log::error('User not found', ['user_id' => $id]);
            return redirect()->route('sign-in')
                ->with('error', 'User not found.');
        }

        \Log::info('User found', [
            'user_id' => $user->id,
            'email' => $user->email,
            'current_verified_at' => $user->email_verified_at
        ]);

        // Check hash only (no expiration check)
        $expectedHash = sha1($user->getEmailForVerification());
        $hashMatches = hash_equals((string) $hash, $expectedHash);
        
        \Log::info('Hash check', [
            'provided' => $hash,
            'expected' => $expectedHash,
            'matches' => $hashMatches
        ]);

        if (!$hashMatches) {
            return redirect()->route('sign-in')
                ->with('error', 'Invalid verification link.');
        }

        // Check if already verified
        if ($user->hasVerifiedEmail()) {
            \Log::info('Already verified', ['email' => $user->email]);
            return redirect()->route('sign-in')
                ->with('success', 'Your email is already verified. Please sign in.');
        }

        // Mark as verified - NO EXPIRATION CHECK
        try {
            $user->markEmailAsVerified();
            
            \Log::info('Email verified successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'verified_at' => $user->fresh()->email_verified_at
            ]);

            return redirect()->route('sign-in')
                ->with('success', 'Your account has been activated successfully! You can now sign in.');
                
        } catch (\Exception $e) {
            \Log::error('Exception during verification', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('sign-in')
                ->with('error', 'An error occurred during verification.');
        }
    }

    /**
     * Show expired link page (keeping for compatibility)
     */
    public function expired(Request $request)
    {
        $email = $request->get('email');
        return view('auth.verification-expired', compact('email'));
    }

    /**
     * Show verification notice
     */
    public function notice(Request $request)
    {
        $email = $request->get('email');
        return view('auth.verify-notice', compact('email'));
    }

    /**
     * Resend verification email
     */
    public function resend(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('sign-in')
                ->with('success', 'Your email is already verified.');
        }

        // Send verification notification
        $user->notify(new \App\Notifications\VerifyEmailNotification($user));

        Log::info('Verification email resent', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);

        return redirect()->route('verification.notice', ['email' => $user->email])
            ->with('success', 'A new verification link has been sent to your email.');
    }
}