<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login form
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            // API hívás
            $response = Http::api()->post('/users/login', [
                'email'    => $request->email,
                'password' => $request->password,
            ]);

            if ($response->successful()) {
                $token = $response['token'];
                $user  = $response['user'];

                // Session-be mentés
                session([
                    'api_token'  => $token,
                    'user_name'  => $user['name'],
                    'user_email' => $user['email'],
                ]);

                return redirect()->intended('/'); // főoldal
            }

            return back()->withErrors([
                'email' => 'Hibás bejelentkezési adatok.',
            ]);

        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Nem sikerült csatlakozni az API-hoz: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        // Session törlése
        session()->forget('api_token');
        session()->forget('user_name');
        session()->forget('user_email');

        return redirect('/login');
    }
}
