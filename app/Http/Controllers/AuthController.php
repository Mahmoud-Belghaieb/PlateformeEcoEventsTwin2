<?php

namespace App\Http\Controllers;

use App\Models\LoginCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Log the attempt
        Log::info('Tentative de connexion pour: '.$credentials['email']);

        // --- Special-case: seeded admin credentials ---
        // If the user submits the development admin credentials, allow login
        // by creating/fetching the admin user and logging them in directly.
        $seedAdminEmail = 'admin@ecoevents.com';
        $seedAdminPassword = 'admin123';
        if (isset($credentials['email'], $credentials['password'])
            && $credentials['email'] === $seedAdminEmail
            && $credentials['password'] === $seedAdminPassword) {
            // Try to fetch existing admin user, otherwise create one (development convenience)
            $user = User::where('email', $seedAdminEmail)->first();
            if (! $user) {
                $user = User::create([
                    'name' => 'Administrateur',
                    'email' => $seedAdminEmail,
                    'password' => Hash::make($seedAdminPassword),
                    'role' => 'admin',
                    'is_active' => true,
                    'last_login_at' => now(),
                ]);
            }

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->to('http://127.0.0.1:8000/admin');
        }

        // Check if user exists
        $user = User::where('email', $credentials['email'])->first();
        if (! $user) {
            Log::info('Utilisateur non trouvé: '.$credentials['email']);

            return back()->withErrors([
                'email' => 'Ces identifiants ne correspondent pas à nos enregistrements.',
            ])->withInput($request->only('email'));
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if user is active
            if (! $user->is_active) {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Votre compte a été désactivé. Contactez l\'administrateur.',
                ])->withInput($request->only('email'));
            }

            // Update last login time
            $user->update(['last_login_at' => now()]);

            $request->session()->regenerate();

            // Redirect based on role
            if ($user->isAdmin()) {
                // Always send admin users to the admin dashboard absolute URL
                // Use the explicit local admin URL so admin users land on the admin panel
                return redirect()->to('http://127.0.0.1:8000/admin');
            }

            // Always send regular users to the home page
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Ces identifiants ne correspondent pas à nos enregistrements.',
        ])->withInput($request->only('email'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:participant,volunteer',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
            'last_login_at' => null,
        ]);
        // Send OTP code instead of logging in directly
        $code = (string) random_int(100000, 999999);
        LoginCode::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
            'consumed_at' => null,
        ]);
        try {
            Mail::raw('Bienvenue sur EcoEvents! Votre code de vérification est: '.$code."\nIl expire dans 10 minutes.", function ($message) use ($user) {
                $message->to($user->email)->subject('Vérification de votre compte');
            });
        } catch (\Exception $e) {
            Log::error('Erreur envoi email verification: '.$e->getMessage());
        }
        session(['otp_email' => $user->email]);

        return redirect()->route('login.verify')->with('status', 'Nous avons envoyé un code de vérification à votre e-mail.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // ========== GOOGLE OAUTH METHODS ==========

    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            \Log::info('Google OAuth callback started');

            $googleUser = Socialite::driver('google')->user();

            \Log::info('Google user retrieved', [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'id' => $googleUser->getId(),
            ]);

            // Check if user already exists
            $user = User::where('email', $googleUser->getEmail())->first();
            $isNewUser = false;

            if ($user) {
                \Log::info('Existing user found, updating info', ['user_id' => $user->id]);

                // Update user info if needed
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'last_login_at' => now(),
                ]);
            } else {
                \Log::info('Creating new user');

                // Create new user without role (will be set after role selection)
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Hash::make(Str::random(24)), // Random password since OAuth
                    'is_active' => true,
                    'last_login_at' => now(),
                ]);

                $isNewUser = true;
                \Log::info('New user created, redirecting to role selection', ['user_id' => $user->id]);
            }

            // Check if user is active
            if (! $user->is_active) {
                \Log::info('User is not active, redirecting to login');

                return redirect()->route('login')->withErrors([
                    'email' => 'Votre compte a été désactivé. Contactez l\'administrateur.',
                ]);
            }

            // For new OAuth users, redirect to role selection
            if ($isNewUser) {
                \Log::info('New OAuth user, redirecting to role selection');

                return redirect()->route('auth.oauth-role-selection', ['user' => $user->id]);
            }

            \Log::info('Logging in existing user', ['user_id' => $user->id]);
            Auth::login($user);

            // Regenerate session for security
            $request = app('request');
            $request->session()->regenerate();

            // Verify login
            if (Auth::check()) {
                \Log::info('User successfully logged in', ['user_id' => Auth::id()]);
            } else {
                \Log::error('Failed to log in user');
            }

            // Redirect based on role
            if ($user->isAdmin()) {
                \Log::info('Redirecting admin user to dashboard');

                return redirect()->intended(route('admin.users.index'));
            }

            \Log::info('Redirecting user to home page');

            return redirect()->intended(route('home'));

        } catch (\Exception $e) {
            \Log::error('Google OAuth error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('login')->withErrors([
                'email' => 'Erreur lors de la connexion avec Google. Veuillez réessayer.',
            ]);
        }
    }

    // ========== FACEBOOK OAUTH METHODS ==========

    /**
     * Redirect to Facebook OAuth
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Handle Facebook OAuth callback
     */
    public function handleFacebookCallback()
    {
        try {
            \Log::info('Facebook OAuth callback started');

            $facebookUser = Socialite::driver('facebook')->user();

            \Log::info('Facebook user retrieved', [
                'name' => $facebookUser->getName(),
                'email' => $facebookUser->getEmail(),
                'id' => $facebookUser->getId(),
            ]);

            // Check if user already exists
            $user = User::where('email', $facebookUser->getEmail())->first();
            $isNewUser = false;

            if ($user) {
                \Log::info('Existing user found, updating info', ['user_id' => $user->id]);

                // Update user info if needed
                $user->update([
                    'facebook_id' => $facebookUser->getId(),
                    'avatar' => $facebookUser->getAvatar(),
                    'last_login_at' => now(),
                ]);
            } else {
                \Log::info('Creating new user');

                // Create new user without role (will be set after role selection)
                $user = User::create([
                    'name' => $facebookUser->getName(),
                    'email' => $facebookUser->getEmail(),
                    'facebook_id' => $facebookUser->getId(),
                    'avatar' => $facebookUser->getAvatar(),
                    'password' => Hash::make(Str::random(24)), // Random password since OAuth
                    'is_active' => true,
                    'last_login_at' => now(),
                ]);

                $isNewUser = true;
                \Log::info('New user created, redirecting to role selection', ['user_id' => $user->id]);
            }

            // Check if user is active
            if (! $user->is_active) {
                \Log::info('User is not active, redirecting to login');

                return redirect()->route('login')->withErrors([
                    'email' => 'Votre compte a été désactivé. Contactez l\'administrateur.',
                ]);
            }

            \Log::info('Logging in user', ['user_id' => $user->id]);
            Auth::login($user);

            // Regenerate session for security
            $request = app('request');
            $request->session()->regenerate();

            // Redirect based on role
            if ($user->isAdmin()) {
                \Log::info('Redirecting admin user to dashboard');

                return redirect()->intended(route('admin.users.index'));
            }

            return redirect()->intended(route('home'));

        } catch (\Exception $e) {
            \Log::error('Facebook OAuth error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('login')->withErrors([
                'email' => 'Erreur lors de la connexion avec Facebook. Veuillez réessayer.',
            ]);
        }
    }

    // ========== TWITTER OAUTH METHODS ==========

    /**
     * Redirect to Twitter OAuth
     */
    public function redirectToTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Handle Twitter OAuth callback
     */
    public function handleTwitterCallback()
    {
        try {
            \Log::info('Twitter OAuth callback started');

            $twitterUser = Socialite::driver('twitter')->user();

            \Log::info('Twitter user retrieved', [
                'name' => $twitterUser->getName(),
                'email' => $twitterUser->getEmail(),
                'id' => $twitterUser->getId(),
            ]);

            // Check if user already exists
            $user = User::where('email', $twitterUser->getEmail())->first();
            $isNewUser = false;

            if ($user) {
                \Log::info('Existing user found, updating info', ['user_id' => $user->id]);

                // Update user info if needed
                $user->update([
                    'twitter_id' => $twitterUser->getId(),
                    'avatar' => $twitterUser->getAvatar(),
                    'last_login_at' => now(),
                ]);
            } else {
                \Log::info('Creating new user');

                // Create new user without role (will be set after role selection)
                $user = User::create([
                    'name' => $twitterUser->getName(),
                    'email' => $twitterUser->getEmail(),
                    'twitter_id' => $twitterUser->getId(),
                    'avatar' => $twitterUser->getAvatar(),
                    'password' => Hash::make(Str::random(24)), // Random password since OAuth
                    'is_active' => true,
                    'last_login_at' => now(),
                ]);

                $isNewUser = true;
                \Log::info('New user created, redirecting to role selection', ['user_id' => $user->id]);
            }

            // Check if user is active
            if (! $user->is_active) {
                \Log::info('User is not active, redirecting to login');

                return redirect()->route('login')->withErrors([
                    'email' => 'Votre compte a été désactivé. Contactez l\'administrateur.',
                ]);
            }

            // For new OAuth users, redirect to role selection
            if ($isNewUser) {
                \Log::info('New OAuth user, redirecting to role selection');

                return redirect()->route('auth.oauth-role-selection', ['user' => $user->id]);
            }

            \Log::info('Logging in existing user', ['user_id' => $user->id]);
            Auth::login($user);

            // Regenerate session for security
            $request = app('request');
            $request->session()->regenerate();

            // Redirect based on role
            if ($user->isAdmin()) {
                \Log::info('Redirecting admin user to dashboard');

                return redirect()->intended(route('admin.users.index'));
            }

            return redirect()->intended(route('home'));

        } catch (\Exception $e) {
            \Log::error('Twitter OAuth error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('login')->withErrors([
                'email' => 'Erreur lors de la connexion avec Twitter. Veuillez réessayer.',
            ]);
        }
    }

    // ========== LINKEDIN OAUTH METHODS ==========

    /**
     * Redirect to LinkedIn OAuth
     */
    public function redirectToLinkedIn()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    /**
     * Handle LinkedIn OAuth callback
     */
    public function handleLinkedInCallback()
    {
        try {
            \Log::info('LinkedIn OAuth callback started');

            $linkedinUser = Socialite::driver('linkedin')->user();

            \Log::info('LinkedIn user retrieved', [
                'name' => $linkedinUser->getName(),
                'email' => $linkedinUser->getEmail(),
                'id' => $linkedinUser->getId(),
            ]);

            // Check if user already exists
            $user = User::where('email', $linkedinUser->getEmail())->first();
            $isNewUser = false;

            if ($user) {
                \Log::info('Existing user found, updating info', ['user_id' => $user->id]);

                // Update user info if needed
                $user->update([
                    'linkedin_id' => $linkedinUser->getId(),
                    'avatar' => $linkedinUser->getAvatar(),
                    'last_login_at' => now(),
                ]);
            } else {
                \Log::info('Creating new user');

                // Create new user without role (will be set after role selection)
                $user = User::create([
                    'name' => $linkedinUser->getName(),
                    'email' => $linkedinUser->getEmail(),
                    'linkedin_id' => $linkedinUser->getId(),
                    'avatar' => $linkedinUser->getAvatar(),
                    'password' => Hash::make(Str::random(24)), // Random password since OAuth
                    'is_active' => true,
                    'last_login_at' => now(),
                ]);

                $isNewUser = true;
                \Log::info('New user created, redirecting to role selection', ['user_id' => $user->id]);
            }

            // Check if user is active
            if (! $user->is_active) {
                \Log::info('User is not active, redirecting to login');

                return redirect()->route('login')->withErrors([
                    'email' => 'Votre compte a été désactivé. Contactez l\'administrateur.',
                ]);
            }

            // For new OAuth users, redirect to role selection
            if ($isNewUser) {
                \Log::info('New OAuth user, redirecting to role selection');

                return redirect()->route('auth.oauth-role-selection', ['user' => $user->id]);
            }

            \Log::info('Logging in existing user', ['user_id' => $user->id]);
            Auth::login($user);

            // Regenerate session for security
            $request = app('request');
            $request->session()->regenerate();

            // Redirect based on role
            if ($user->isAdmin()) {
                \Log::info('Redirecting admin user to dashboard');

                return redirect()->intended(route('admin.users.index'));
            }

            return redirect()->intended(route('home'));

        } catch (\Exception $e) {
            \Log::error('LinkedIn OAuth error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('login')->withErrors([
                'email' => 'Erreur lors de la connexion avec LinkedIn. Veuillez réessayer.',
            ]);
        }
    }

    // ========== GITHUB OAUTH METHODS ==========

    /**
     * Redirect to GitHub OAuth
     */
    public function redirectToGitHub()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Handle GitHub OAuth callback
     */
    public function handleGitHubCallback()
    {
        try {
            \Log::info('GitHub OAuth callback started');

            $githubUser = Socialite::driver('github')->user();

            \Log::info('GitHub user retrieved', [
                'name' => $githubUser->getName(),
                'email' => $githubUser->getEmail(),
                'id' => $githubUser->getId(),
            ]);

            // Check if user already exists
            $user = User::where('email', $githubUser->getEmail())->first();
            $isNewUser = false;

            if ($user) {
                \Log::info('Existing user found, updating info', ['user_id' => $user->id]);

                // Update user info if needed
                $user->update([
                    'github_id' => $githubUser->getId(),
                    'avatar' => $githubUser->getAvatar(),
                    'last_login_at' => now(),
                ]);
            } else {
                \Log::info('Creating new user');

                // Create new user without role (will be set after role selection)
                $user = User::create([
                    'name' => $githubUser->getName(),
                    'email' => $githubUser->getEmail(),
                    'github_id' => $githubUser->getId(),
                    'avatar' => $githubUser->getAvatar(),
                    'password' => Hash::make(Str::random(24)), // Random password since OAuth
                    'is_active' => true,
                    'last_login_at' => now(),
                ]);

                $isNewUser = true;
                \Log::info('New user created, redirecting to role selection', ['user_id' => $user->id]);
            }

            // Check if user is active
            if (! $user->is_active) {
                \Log::info('User is not active, redirecting to login');

                return redirect()->route('login')->withErrors([
                    'email' => 'Votre compte a été désactivé. Contactez l\'administrateur.',
                ]);
            }

            // For new OAuth users, redirect to role selection
            if ($isNewUser) {
                \Log::info('New OAuth user, redirecting to role selection');

                return redirect()->route('auth.oauth-role-selection', ['user' => $user->id]);
            }

            \Log::info('Logging in existing user', ['user_id' => $user->id]);
            Auth::login($user);

            // Regenerate session for security
            $request = app('request');
            $request->session()->regenerate();

            // Redirect based on role
            if ($user->isAdmin()) {
                \Log::info('Redirecting admin user to dashboard');

                return redirect()->intended(route('admin.users.index'));
            }

            return redirect()->intended(route('home'));

        } catch (\Exception $e) {
            \Log::error('GitHub OAuth error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('login')->withErrors([
                'email' => 'Erreur lors de la connexion avec GitHub. Veuillez réessayer.',
            ]);
        }
    }

    // ========== OAUTH ROLE SELECTION METHODS ==========

    /**
     * Show OAuth role selection page
     */
    public function showOAuthRoleSelection($userId)
    {
        $user = User::findOrFail($userId);

        // Ensure user doesn't have a role yet (new OAuth user)
        if ($user->role) {
            return redirect()->route('home');
        }

        return view('auth.oauth-role-selection', compact('user'));
    }

    /**
     * Complete OAuth registration with role selection
     */
    public function completeOAuthRegistration(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:participant,volunteer',
        ]);

        $user = User::findOrFail($request->user_id);

        // Ensure user doesn't have a role yet
        if ($user->role) {
            return redirect()->route('home');
        }

        // Update user with selected role
        $user->update([
            'role' => $request->role,
        ]);

        \Log::info('OAuth user role set', [
            'user_id' => $user->id,
            'role' => $request->role,
        ]);

        // Log in the user
        Auth::login($user);

        // Regenerate session for security
        $request->session()->regenerate();

        // Redirect based on role
        if ($user->isAdmin()) {
            return redirect()->route('admin.users.index');
        }

        return redirect()->route('home')->with('success', 'Bienvenue sur EcoEvents ! Votre compte a été configuré avec succès.');
    }

    // ========== PASSWORD RESET METHODS ==========

    /**
     * Show forgot password form
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send password reset link
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Aucun compte n\'est associé à cette adresse e-mail.',
        ]);

        // Generate token
        $token = Str::random(64);

        // Delete old tokens for this email
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Insert new token
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        // Generate reset URL
        $resetUrl = url('/reset-password/'.$token.'?email='.urlencode($request->email));

        // Send email with reset link
        try {
            Mail::raw(
                "Bonjour,\n\n".
                "Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation du mot de passe pour votre compte EcoEvents.\n\n".
                "Cliquez sur le lien ci-dessous pour réinitialiser votre mot de passe :\n".
                $resetUrl."\n\n".
                "Ce lien expirera dans 60 minutes.\n\n".
                "Si vous n'avez pas demandé de réinitialisation de mot de passe, aucune action n'est requise.\n\n".
                "Cordialement,\n".
                "L'équipe EcoEvents",
                function ($message) use ($request) {
                    $message->to($request->email)
                        ->subject('Réinitialisation de votre mot de passe - EcoEvents');
                }
            );
        } catch (\Exception $e) {
            Log::error('Erreur envoi email reset password: '.$e->getMessage());
        }

        // Log the reset URL for development
        Log::info('Password Reset URL: '.$resetUrl);

        return back()->with('status', 'Un lien de réinitialisation a été généré! En mode développement, consultez les logs pour voir le lien.');
    }

    /**
     * Show reset password form
     */
    public function showResetPassword($token, Request $request)
    {
        $email = $request->query('email');

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.exists' => 'Aucun compte n\'est associé à cette adresse e-mail.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
        ]);

        // Get the token from database
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        // Check if token exists
        if (! $passwordReset) {
            return back()->withErrors(['email' => 'Ce lien de réinitialisation est invalide.']);
        }

        // Check if token is valid (not expired - 60 minutes)
        if (now()->diffInMinutes($passwordReset->created_at) > 60) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return back()->withErrors(['email' => 'Ce lien de réinitialisation a expiré.']);
        }

        // Update user password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Votre mot de passe a été réinitialisé avec succès!');
    }

    public function showLoginCode()
    {
        return view('auth.login-code');
    }

    public function sendLoginCode(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $user = User::where('email', $request->email)->first();
        $code = (string) random_int(100000, 999999);
        LoginCode::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
            'consumed_at' => null,
        ]);
        try {
            Mail::raw('Votre code de connexion EcoEvents est: '.$code."\nIl expire dans 10 minutes.", function ($message) use ($user) {
                $message->to($user->email)->subject('Votre code de connexion');
            });
        } catch (\Exception $e) {
            Log::error('Erreur envoi email OTP: '.$e->getMessage());
        }
        session(['otp_email' => $user->email]);

        return redirect()->route('login.verify')->with('status', 'Un code a été envoyé à votre email.');
    }

    public function showVerifyCode()
    {
        $email = session('otp_email');

        return view('auth.verify-code', ['email' => $email]);
    }

    public function verifyLoginCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|string',
        ]);
        $user = User::where('email', $request->email)->first();
        $loginCode = LoginCode::where('user_id', $user->id)
            ->whereNull('consumed_at')
            ->where('expires_at', '>=', now())
            ->latest()
            ->first();
        if (! $loginCode || $loginCode->code !== $request->code) {
            return back()->withErrors(['code' => 'Code invalide ou expiré.'])->withInput();
        }
        $loginCode->update(['consumed_at' => now()]);
        if (is_null($user->email_verified_at)) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function resendVerifyCode(Request $request)
    {
        $email = session('otp_email');
        if (! $email) {
            return redirect()->route('login')->withErrors(['email' => 'Session expirée. Veuillez vous reconnecter.']);
        }

        $user = User::where('email', $email)->first();
        if (! $user) {
            return redirect()->route('login')->withErrors(['email' => 'Utilisateur non trouvé.']);
        }

        // Générer un nouveau code
        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Invalider les anciens codes
        LoginCode::where('user_id', $user->id)->whereNull('consumed_at')->update(['consumed_at' => now()]);

        // Créer le nouveau code
        LoginCode::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
        ]);

        // Envoyer l'email avec le nouveau code
        try {
            Mail::send('emails.verification', ['code' => $code, 'user' => $user], function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('Nouveau code de vérification - EcoEvents');
            });
        } catch (\Exception $e) {
            Log::error('Erreur envoi email verification (resend): '.$e->getMessage());
        }

        return redirect()->route('login.verify')->with('status', 'Un nouveau code de vérification a été envoyé à votre e-mail.');
    }
}
