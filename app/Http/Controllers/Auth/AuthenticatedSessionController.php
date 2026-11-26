<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        if ($request->boolean('checkout')) {
            $type = $request->query('room_type');
            $room = in_array($type, ['single', 'double', 'family', 'superior'], true) ? $type : 'single';
            redirect()->setIntendedUrl(route('reservations.create', ['room_type' => $room]));
        }

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();
        // Accounts created before the role migration have no role column.
        $isCustomer = ! array_key_exists('role_id', $user->getAttributes())
            || DB::table('user_roles')->where('role_id', $user->role_id)
                ->whereIn('role_name', ['guest', 'account_user'])->exists();

        if ($isCustomer) {
            $now = now();
            DB::table('admin_notifications')->insert([
                'event_type' => 'customer_login',
                'message' => 'A customer signed in.',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
