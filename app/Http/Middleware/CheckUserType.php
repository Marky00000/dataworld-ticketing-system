<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    public function handle(Request $request, Closure $next, ...$types)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('sign-in');
        }
        
        if (!in_array($user->user_type, $types)) {
            // Option 1: Redirect to appropriate dashboard
            switch ($user->user_type) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'tech':
                    return redirect()->route('tech.dashboard');
                case 'user':
                    return redirect()->route('user.dashboard');
                default:
                    return redirect()->route('dashboard');
            }
            
            // Option 2: Show unauthorized page
            // return redirect()->route('unauthorized');
        }
        
        return $next($request);
    }
}