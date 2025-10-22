<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
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
                return redirect()->intended(route('admin.users.index'));
            }

            return redirect()->intended(route('home'));
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
            'last_login_at' => now(),
        ]);
        Auth::login($user);

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
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
            \Log::error('Erreur envoi email reset password: '.$e->getMessage());
        }

        // Log the reset URL for development
        \Log::info('Password Reset URL: '.$resetUrl);

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
}
