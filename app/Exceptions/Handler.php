<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // Handle expired signature exceptions
        if ($exception instanceof InvalidSignatureException) {
            // Try to extract email from the request
            $email = null;
            
            // Check if the route has an 'id' parameter
            if ($request->route('id')) {
                $user = \App\Models\User::find($request->route('id'));
                $email = $user ? $user->email : null;
            }
            
            // If no user found with id, try to get from query string
            if (!$email && $request->has('email')) {
                $email = $request->get('email');
            }
            
            // Redirect to your custom expired page
            return redirect()->route('verification.expired', ['email' => $email])
                ->with('error', 'This activation link has expired. Please request a new one.');
        }

        return parent::render($request, $exception);
    }
}