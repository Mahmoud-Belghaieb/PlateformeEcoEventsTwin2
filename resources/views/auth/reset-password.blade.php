<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe - EcoEvents</title>
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

        .reset-container {
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

        .icon-wrapper {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }

        .icon-wrapper i {
            font-size: 28px;
            color: white;
        }

        .header h2 {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 12px;
        }

        .header p {
            font-size: 14px;
            color: var(--light-text);
            line-height: 1.6;
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

        .submit-btn {
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

        .submit-btn:hover {
            background: linear-gradient(135deg, #047857 0%, #059669 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .error-container {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 12px;
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
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .error-container li:last-child {
            margin-bottom: 0;
        }

        .error-container i {
            color: #ef4444;
        }

        .password-requirements {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 12px;
            margin-top: 8px;
            text-align: left;
        }

        .password-requirements p {
            font-size: 12px;
            color: #0369a1;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .password-requirements ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .password-requirements li {
            font-size: 12px;
            color: #0c4a6e;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .password-requirements li i {
            color: #0284c7;
            font-size: 10px;
        }

        .eye-icon {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }

        @media (max-width: 480px) {
            .reset-container {
                padding: 32px 24px;
                margin: 16px;
            }
            
            .header h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <div class="header">
            <div class="logo">
                <i class="fas fa-leaf"></i>
                <span>EcoEvents</span>
            </div>
            
            <div class="icon-wrapper">
                <i class="fas fa-lock"></i>
            </div>
            
            <h2>Nouveau mot de passe</h2>
            <p>Choisissez un nouveau mot de passe sécurisé pour votre compte.</p>
        </div>

        @if($errors->any())
            <div class="error-container">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="form-group">
                <label for="email">Adresse e-mail<span class="required">*</span></label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', $email ?? '') }}" 
                       placeholder="votre@email.com"
                       required
                       autofocus>
            </div>

            <div class="form-group">
                <label for="password">Nouveau mot de passe<span class="required">*</span></label>
                <div class="input-wrapper">
                    <input type="password" 
                           id="password" 
                           name="password" 
                           placeholder="••••••••"
                           required>
                    <span class="password-toggle" onclick="togglePassword('password')">
                        <svg class="eye-icon" viewBox="0 0 24 24">
                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe<span class="required">*</span></label>
                <div class="input-wrapper">
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           placeholder="••••••••"
                           required>
                    <span class="password-toggle" onclick="togglePassword('password_confirmation')">
                        <svg class="eye-icon" viewBox="0 0 24 24">
                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="password-requirements">
                <p><i class="fas fa-info-circle"></i> Exigences du mot de passe :</p>
                <ul>
                    <li><i class="fas fa-circle"></i> Au moins 6 caractères</li>
                    <li><i class="fas fa-circle"></i> Les deux mots de passe doivent correspondre</li>
                </ul>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-check me-2"></i>
                Réinitialiser le mot de passe
            </button>
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