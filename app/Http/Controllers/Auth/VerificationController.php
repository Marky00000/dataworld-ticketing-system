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
        $user = User::findOrFail($id);

        // Check if the hash matches
        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect()->route('verification.expired', ['email' => $user->email])
                ->with('error', 'Invalid verification link.');
        }

        // Check if the link has expired
        if (!$request->hasValidSignature()) {
            Log::warning('Expired verification link', [
                'user_id' => $id,
                'email' => $user->email
            ]);
            
            return redirect()->route('verification.expired', ['email' => $user->email])
                ->with('error', 'This activation link has expired. Please request a new one.');
        }

        // Check if already verified
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('sign-in')
                ->with('success', 'Your email is already verified. Please sign in.');
        }

        // Mark email as verified
        $user->markEmailAsVerified();
        
        Log::info('Email verified successfully', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);

        return redirect()->route('sign-in')
            ->with('success', 'Your account has been activated successfully! You can now sign in.');
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