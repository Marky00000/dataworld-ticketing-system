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
     * Verify email
     */
   public function verify(Request $request, $id, $hash)
{
    // Add this at the VERY TOP
    \Log::info('=== VERIFICATION DEBUG ===', [
        'user_id' => $id,
        'hash' => $hash,
        'expires' => $request->get('expires'),
        'signature' => $request->get('signature'),
        'full_url' => $request->fullUrl(),
        'method' => $request->method(),
        'timestamp' => now()->format('Y-m-d H:i:s')
    ]);

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

    // Check signature
    $hasValidSignature = $request->hasValidSignature();
    \Log::info('Signature check', [
        'has_valid_signature' => $hasValidSignature
    ]);

    if (!$hasValidSignature) {
        \Log::warning('Expired verification link', [
            'user_id' => $id,
            'email' => $user->email
        ]);
        
        return redirect()->route('verification.expired', ['email' => $user->email])
            ->with('error', 'This activation link has expired. Please request a new one.');
    }

    // Check hash
    $expectedHash = sha1($user->getEmailForVerification());
    $hashMatches = hash_equals((string) $hash, $expectedHash);
    
    \Log::info('Hash check', [
        'provided' => $hash,
        'expected' => $expectedHash,
        'matches' => $hashMatches
    ]);

    if (!$hashMatches) {
        return redirect()->route('verification.expired', ['email' => $user->email])
            ->with('error', 'Invalid verification link.');
    }

    // Check if already verified
    if ($user->hasVerifiedEmail()) {
        \Log::info('Already verified', ['email' => $user->email]);
        return redirect()->route('sign-in')
            ->with('success', 'Your email is already verified. Please sign in.');
    }

    // Mark as verified
    try {
        $result = $user->markEmailAsVerified();
        
        \Log::info('Mark email as verified result', [
            'result' => $result,
            'new_verified_at' => $user->fresh()->email_verified_at
        ]);

        if ($result) {
            \Log::info('Email verified successfully', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            return redirect()->route('sign-in')
                ->with('success', 'Your account has been activated successfully! You can now sign in.');
        } else {
            \Log::error('Failed to mark email as verified', [
                'user_id' => $user->id
            ]);
            
            return redirect()->route('sign-in')
                ->with('error', 'Failed to verify email. Please try again.');
        }
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
     * Show expired link page
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