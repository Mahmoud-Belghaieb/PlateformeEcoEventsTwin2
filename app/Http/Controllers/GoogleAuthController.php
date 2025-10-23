<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        $clientId = Config::get('services.google.client_id');
        $redirectUri = Config::get('services.google.redirect');
        $state = Str::random(40);
        Session::put('google_oauth_state', $state);

        $params = http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'access_type' => 'offline',
            'prompt' => 'consent',
        ]);

        return redirect('https://accounts.google.com/o/oauth2/v2/auth?'.$params);
    }

    public function callback(Request $request)
    {
        // Try to validate state, but don't hard fail in dev to avoid loopbacks
        $expectedState = Session::pull('google_oauth_state');
        $incomingState = $request->query('state');
        if ($expectedState && $incomingState && $expectedState !== $incomingState) {
            Log::warning('Google OAuth state mismatch', ['expected' => $expectedState, 'incoming' => $incomingState]);
        }

        $code = $request->query('code');
        if (! $code) {
            return redirect()->route('login')->withErrors(['email' => 'Code OAuth manquant.']);
        }

        $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'code' => $code,
            'client_id' => Config::get('services.google.client_id'),
            'client_secret' => Config::get('services.google.client_secret'),
            'redirect_uri' => Config::get('services.google.redirect'),
            'grant_type' => 'authorization_code',
        ]);

        if (! $tokenResponse->ok()) {
            Log::error('Google token exchange failed', ['body' => $tokenResponse->body()]);

            return redirect()->route('login')->withErrors(['email' => 'Echec de connexion Google.']);
        }

        $accessToken = $tokenResponse->json('access_token');
        // Retrieve userinfo
        $userInfoResp = Http::withToken($accessToken)
            ->get('https://www.googleapis.com/oauth2/v3/userinfo');

        if (! $userInfoResp->ok()) {
            Log::error('Google userinfo failed', ['body' => $userInfoResp->body()]);

            return redirect()->route('login')->withErrors(['email' => 'Impossible de récupérer le profil Google.']);
        }

        $google = (object) $userInfoResp->json();
        $email = $google->email ?? null;
        $name = $google->name ?? ($google->given_name ?? 'Utilisateur');

        if (! $email) {
            return redirect()->route('login')->withErrors(['email' => 'Le compte Google ne fournit pas d\'email.']);
        }

        // Find or create user
        $user = User::where('email', $email)->first();
        if (! $user) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make(Str::random(32)),
                'role' => 'participant',
                'is_active' => true,
                'last_login_at' => now(),
            ]);
        }
        // mark email verified if model has this column
        if (\Schema::hasColumn('users', 'email_verified_at') && is_null($user->email_verified_at)) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        Auth::login($user);
        $request->session()->regenerate();

        // Redirect by role
        if (property_exists($user, 'role') || isset($user->role)) {
            if ($user->role === 'admin') {
                return redirect()->to('http://127.0.0.1:8000/admin');
            }
        }

        return redirect()->intended(route('home'));
    }
}
