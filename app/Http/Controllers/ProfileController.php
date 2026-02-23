<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * ADD THIS NEW METHOD - Display the user's profile dashboard
     */
    /**
 * Display the user's profile dashboard
 */
public function dashboard()
{
    $user = Auth::user(); // Get the currently authenticated user
    
    // Get ticket statistics for this user
    $totalTickets = Ticket::where('created_by', $user->id)->count();
    $activeTickets = Ticket::where('created_by', $user->id)
        ->whereIn('status', ['pending', 'open', 'in_progress'])
        ->count();
    $resolvedTickets = Ticket::where('created_by', $user->id)
        ->whereIn('status', ['resolved', 'closed'])
        ->count();
    
    // Get recent tickets
    $recentTickets = Ticket::where('created_by', $user->id)
        ->with(['assignedTech', 'category'])
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();
    
    // Calculate average response time
    $avgResponse = '1.2h'; // You can calculate this from your data
    
    return view('profile.dashboard', compact(
        'user', 
        'totalTickets', 
        'activeTickets', 
        'resolvedTickets', 
        'recentTickets',
        'avgResponse'
    ));
}
}