<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - EcoEvents</title>
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

        .forgot-container {
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

        input[type="email"] {
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

        .back-link {
            margin-top: 24px;
            text-align: center;
        }

        .back-link a {
            color: var(--light-text);
            text-decoration: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: color 0.3s ease;
        }

        .back-link a:hover {
            color: var(--primary-green);
        }

        .success-container {
            background-color: #f0fdf4;
            border: 1px solid #86efac;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 20px;
            text-align: left;
        }

        .success-container p {
            color: #166534;
            font-size: 14px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .success-container i {
            color: #22c55e;
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

        .success-container {
            background-color: #d1fae5;
            border: 1px solid #6ee7b7;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
            text-align: left;
        }

        .success-container p {
            color: #065f46;
            font-size: 14px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }

        .success-container i {
            color: #10b981;
            font-size: 16px;
        }

        .info-box {
            background: #dbeafe;
            border: 1px solid #93c5fd;
            border-radius: 8px;
            padding: 12px;
            margin-top: 16px;
            text-align: left;
        }

        .info-box p {
            color: #1e40af;
            font-size: 13px;
            margin: 0;
            line-height: 1.5;
        }

        .info-box strong {
            color: #1e3a8a;
        }

        @media (max-width: 480px) {
            .forgot-container {
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
    <div class="forgot-container">
        <div class="header">
            <div class="logo">
                <i class="fas fa-leaf"></i>
                <span>EcoEvents</span>
            </div>
            
            <div class="icon-wrapper">
                <i class="fas fa-key"></i>
            </div>
            
            <h2>Mot de passe oublié ?</h2>
            <p>Entrez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
        </div>

        @if(session('status'))
            <div class="success-container">
                <p>
                    <i class="fas fa-check-circle"></i>
                    {{ session('status') }}
                </p>
            </div>
        @endif

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

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Adresse e-mail<span class="required">*</span></label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       placeholder="votre@email.com"
                       required
                       autofocus>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-paper-plane me-2"></i>
                Envoyer le lien de réinitialisation
            </button>
        </form>

        @if(config('mail.default') === 'log')
            <div class="info-box">
                <p>
                    <strong>ℹ️ Mode Développement :</strong><br>
                    Les emails sont enregistrés dans les logs.<br>
                    <a href="{{ route('admin.email-logs') }}" style="color: #1e40af; text-decoration: underline;">
                        Voir les emails ici →
                    </a>
                </p>
            </div>
        @endif

        <div class="back-link">
            <a href="{{ route('login') }}">
                <i class="fas fa-arrow-left"></i>
                Retour à la connexion
            </a>
        </div>
    </div>
</body>
</html>