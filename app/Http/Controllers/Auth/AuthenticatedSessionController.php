<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $response = Http::api()->post('/users/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if (!$response->successful()) {
            return back()->withErrors([
                'email' => 'Hibás bejelentkezési adatok.',
            ]);
        }

        $data = $response->json();

        if (!isset($data['token'])) {
            return back()->withErrors(['email' => 'Nem kaptunk token-t az API-tól.']);
        }

        // --- Store API user data in session ---
        session([
            'api_token' => $data['token'],
            'user' => [
                'email' => $data['user']['email'] ?? $request->email,
                'name' => $data['user']['name'] ?? 'Felhasználó',
            ],
        ]);

        return redirect()->intended('/');
    }

    public function destroy()
    {
        session()->forget(['api_token', 'user']);

        return redirect('/login');
    }
}