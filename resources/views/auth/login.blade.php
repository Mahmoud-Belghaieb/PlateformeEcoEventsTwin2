<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in - EcoEvents</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-green: #059669;
            --secondary-green: #10b981;
            --accent-orange: #f97316;
            --dark-text: #1f2937;
            --light-text: #6b7280;
            --background: #f9fafb;
            --white: #ffffff;
            --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #f0f9ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="c" cx="50%" r="20%"><stop offset="0%" stop-color="%2310b981" stop-opacity="0.1"/><stop offset="100%" stop-color="%2310b981" stop-opacity="0"/></radialGradient></defs><rect fill="url(%23c)" width="100%" height="100%"/></svg>');
            opacity: 0.6;
        }

        .signin-container {
            background: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow);
            padding: 48px 40px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            position: relative;
            z-index: 1;
            border: 1px solid rgba(16, 185, 129, 0.1);
        }

        .header {
            margin-bottom: 32px;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }

        .logo i {
            font-size: 2rem;
            color: var(--accent-orange);
        }

        .logo span {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary-green);
        }

        .header h1 {
            font-size: 24px;
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 8px;
        }

        .header h2 {
            font-size: 32px;
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 16px;
        }

        .signup-link {
            font-size: 14px;
            color: var(--light-text);
        }

        .signup-link a {
            color: var(--accent-orange);
            text-decoration: none;
            font-weight: 600;
        }

        .signup-link a:hover {
            color: #ea580c;
            text-decoration: underline;
        }

        .forgot-password-link a:hover {
            color: #ea580c;
            text-decoration: underline;
        }

        .form-group {
            margin-bottom: 24px;
            text-align: left;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 8px;
        }

        .required {
            color: #dc2626;
        }

        .input-wrapper {
            position: relative;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 16px;
            background-color: var(--white);
            transition: all 0.3s ease;
            font-family: inherit;
        }

        input:focus {
            outline: none;
            border-color: var(--primary-green);
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
            transform: translateY(-2px);
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--light-text);
            padding: 4px;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--primary-green);
        }

        .signin-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 8px;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
        }

        .signin-btn:hover {
            background: linear-gradient(135deg, #047857 0%, #059669 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4);
        }
        }

        .signin-btn:active {
            transform: translateY(0);
        }

        .error-container {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            text-align: left;
        }

        .error-container ul {
            list-style: none;
            margin: 0;
        }

        .error-container li {
            color: #dc2626;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .error-container li:last-child {
            margin-bottom: 0;
        }

        @media (max-width: 480px) {
            .signin-container {
                padding: 32px 24px;
                margin: 16px;
            }
            
            .header h2 {
                font-size: 28px;
            }
        }

        /* Eye icon styles */
        .eye-icon {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }
    </style>
</head>
<body>
    <div class="signin-container">
        <div class="header">
            <div class="logo">
                <i class="fas fa-leaf"></i>
                <span>EcoEvents</span>
            </div>
            <h2>Sign in</h2>
            <div class="signup-link">
                or <a href="{{ route('register') }}">sign up for an account</a>
            </div>
        </div>

        @if($errors->any())
            <div class="error-container">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Social Media Login Buttons -->
        <div style="margin-bottom: 24px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; margin-bottom: 20px;">
                <!-- Google Login Button -->
                <a href="{{ route('auth.google') }}" 
                   style="display: inline-flex; align-items: center; justify-content: center; gap: 12px; padding: 14px 16px; background: #ffffff; border: 2px solid #e5e7eb; border-radius: 12px; text-decoration: none; color: #374151; font-weight: 600; font-size: 16px; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                    <svg width="20" height="20" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Google
                </a>

                <!-- Facebook Login Button -->
                <a href="{{ route('auth.facebook') }}" 
                   style="display: inline-flex; align-items: center; justify-content: center; gap: 12px; padding: 14px 16px; background: #1877f2; border: 2px solid #1877f2; border-radius: 12px; text-decoration: none; color: #ffffff; font-weight: 600; font-size: 16px; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(24, 119, 242, 0.3);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </a>

                <!-- Twitter Login Button -->
                <a href="{{ route('auth.twitter') }}" 
                   style="display: inline-flex; align-items: center; justify-content: center; gap: 12px; padding: 14px 16px; background: #1da1f2; border: 2px solid #1da1f2; border-radius: 12px; text-decoration: none; color: #ffffff; font-weight: 600; font-size: 16px; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(29, 161, 242, 0.3);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                    Twitter
                </a>

                <!-- LinkedIn Login Button -->
                <a href="{{ route('auth.linkedin') }}" 
                   style="display: inline-flex; align-items: center; justify-content: center; gap: 12px; padding: 14px 16px; background: #0077b5; border: 2px solid #0077b5; border-radius: 12px; text-decoration: none; color: #ffffff; font-weight: 600; font-size: 16px; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0, 119, 181, 0.3);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                    LinkedIn
                </a>

                <!-- GitHub Login Button -->
                <a href="{{ route('auth.github') }}" 
                   style="display: inline-flex; align-items: center; justify-content: center; gap: 12px; padding: 14px 16px; background: #24292e; border: 2px solid #24292e; border-radius: 12px; text-decoration: none; color: #ffffff; font-weight: 600; font-size: 16px; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(36, 41, 46, 0.3);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                    </svg>
                    GitHub
                </a>
            </div>
        </div>

        <div style="text-align: center; margin: 20px 0; position: relative;">
            <span style="background: var(--white); padding: 0 16px; color: var(--light-text); font-size: 14px;">ou</span>
            <hr style="border: none; border-top: 1px solid #e5e7eb; position: absolute; top: 50%; left: 0; right: 0; z-index: -1;">
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Email address<span class="required">*</span></label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required>
            </div>

            <div class="form-group">
                <label for="password">Password<span class="required">*</span></label>
                <div class="input-wrapper">
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required>
                    <span class="password-toggle" onclick="togglePassword('password')">
                        <svg class="eye-icon" viewBox="0 0 24 24">
                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="forgot-password-link" style="text-align: right; margin-bottom: 20px;">
                <a href="{{ route('password.request') }}" style="color: var(--accent-orange); text-decoration: none; font-size: 14px; font-weight: 500;">
                    <i class="fas fa-key" style="margin-right: 4px;"></i>
                    Forgot password?
                </a>
            </div>

            <button type="submit" class="signin-btn">Sign in</button>
        </form>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
            field.setAttribute('type', type);
        }
    </script>
</body>
</html>
