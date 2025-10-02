<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoEvents - Sustainable Event Management Platform</title>
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
            background: var(--background);
            color: var(--dark-text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary-green);
            text-decoration: none;
        }

        .logo i {
            color: var(--accent-orange);
        }

        .nav-links {
            display: flex;
            gap: 2.5rem;
            align-items: center;
        }

        .nav-link {
            color: var(--light-text);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            position: relative;
        }

        .nav-link:hover {
            color: var(--primary-green);
            background: rgba(16, 185, 129, 0.1);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 12px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: var(--primary-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .user-name {
            color: var(--dark-text);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.8rem;
            color: var(--light-text);
        }

        .logout-btn {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
        }

        .hero-section {
            padding: 10rem 0 6rem;
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #f0f9ff 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="c" cx="50%" r="20%"><stop offset="0%" stop-color="%2310b981" stop-opacity="0.1"/><stop offset="100%" stop-color="%2310b981" stop-opacity="0"/></radialGradient></defs><rect fill="url(%23c)" width="100%" height="100%"/></svg>');
            opacity: 0.6;
        }

        .hero-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-content {
            position: relative;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, var(--accent-orange), #ea580c);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 30px;
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 2rem;
            animation: pulse 2s ease-in-out infinite;
            box-shadow: 0 8px 25px rgba(249, 115, 22, 0.3);
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 2rem;
            color: var(--dark-text);
        }

        .hero-title .accent {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            line-height: 1.7;
            color: var(--light-text);
            margin-bottom: 3rem;
            max-width: 600px;
        }

        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            padding: 1.2rem 2.5rem;
            border: none;
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 10px 30px rgba(5, 150, 105, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(5, 150, 105, 0.4);
        }

        .btn-secondary {
            background: white;
            color: var(--primary-green);
            padding: 1.2rem 2.5rem;
            border: 2px solid var(--primary-green);
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-secondary:hover {
            background: var(--primary-green);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(5, 150, 105, 0.3);
        }

        .hero-stats {
            display: flex;
            gap: 2rem;
            margin-top: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 20px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(16, 185, 129, 0.1);
            text-align: center;
            min-width: 120px;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 900;
            color: var(--primary-green);
            display: block;
        }

        .stat-label {
            color: var(--light-text);
            font-size: 0.9rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .hero-visual {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .visual-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 1.5rem;
            width: 500px;
            height: 500px;
        }

        .visual-card {
            background: white;
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(16, 185, 129, 0.1);
            position: relative;
            overflow: hidden;
        }

        .visual-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .visual-card:hover::before {
            opacity: 0.05;
        }

        .visual-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
        }

        .visual-card i {
            font-size: 3rem;
            color: var(--primary-green);
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .visual-card h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .visual-card p {
            font-size: 0.85rem;
            color: var(--light-text);
            line-height: 1.4;
            position: relative;
            z-index: 1;
        }

        .main-visual {
            grid-column: span 2;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
        }

        .main-visual i {
            color: white;
            font-size: 4rem;
        }

        .main-visual h3 {
            color: white;
            font-size: 1.8rem;
        }

        .main-visual p {
            color: rgba(255, 255, 255, 0.9);
        }

        .events-section {
            padding: 8rem 0;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        }

        .events-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
            gap: 2.5rem;
            margin-bottom: 4rem;
        }

        .event-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .event-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .event-image {
            position: relative;
            height: 220px;
            overflow: hidden;
        }

        .event-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
            background: #f3f4f6;
        }

        .event-card:hover .event-image img {
            transform: scale(1.05);
        }

        .event-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            gap: 0.5rem;
        }

        .event-placeholder .placeholder-text {
            font-size: 0.9rem;
            font-weight: 600;
            opacity: 0.9;
        }

        .featured-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: linear-gradient(135deg, var(--accent-orange), #ea580c);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
        }

        .category-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--primary-green);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .event-content {
            padding: 2rem;
            display: flex;
            gap: 1.5rem;
        }

        .event-date {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            border-radius: 16px;
            padding: 1rem;
            text-align: center;
            min-width: 70px;
            height: fit-content;
        }

        .date-day {
            font-size: 1.8rem;
            font-weight: 900;
            line-height: 1;
        }

        .date-month {
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-top: 0.25rem;
        }

        .event-info {
            flex: 1;
        }

        .event-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 0.75rem;
            line-height: 1.3;
        }

        .event-description {
            color: var(--light-text);
            line-height: 1.6;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .event-meta {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .event-meta > div {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
            color: var(--light-text);
        }

        .event-meta i {
            color: var(--primary-green);
            width: 16px;
        }

        .event-price.free {
            color: var(--secondary-green);
            font-weight: 600;
        }

        .event-actions {
            padding: 0 2rem 2rem;
            display: flex;
            gap: 1rem;
        }

        .btn-register, .btn-details {
            flex: 1;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            text-align: center;
        }

        .btn-register {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            border: none;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3);
        }

        .btn-details {
            background: white;
            color: var(--primary-green);
            border: 2px solid var(--primary-green);
        }

        .btn-details:hover {
            background: var(--primary-green);
            color: white;
        }

        .btn-registered {
            flex: 1;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: rgba(16, 185, 129, 0.1);
            color: var(--primary-green);
            border: 2px solid rgba(16, 185, 129, 0.3);
            cursor: not-allowed;
        }

        .events-cta {
            text-align: center;
            margin-top: 3rem;
        }

        .btn-see-all {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            padding: 1.2rem 2.5rem;
            border: none;
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 10px 30px rgba(5, 150, 105, 0.3);
        }

        .btn-see-all:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(5, 150, 105, 0.4);
        }

        .no-events {
            text-align: center;
            padding: 6rem 2rem;
            background: white;
            border-radius: 24px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(16, 185, 129, 0.1);
        }

        .no-events-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2.5rem;
            color: white;
        }

        .no-events h3 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 1rem;
        }

        .no-events p {
            color: var(--light-text);
            font-size: 1.1rem;
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-create-event {
            background: linear-gradient(135deg, var(--accent-orange), #ea580c);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-create-event:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(249, 115, 22, 0.3);
        }

        .features-section {
            padding: 8rem 0;
            background: white;
        }

        .features-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .section-header {
            text-align: center;
            margin-bottom: 5rem;
        }

        .section-title {
            font-size: 3rem;
            font-weight: 900;
            color: var(--dark-text);
            margin-bottom: 1.5rem;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: var(--light-text);
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 3rem;
        }

        .feature-card {
            background: white;
            padding: 3rem;
            border-radius: 24px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(16, 185, 129, 0.1);
            transition: all 0.3s ease;
            text-align: center;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2rem;
            color: white;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: var(--light-text);
            line-height: 1.6;
        }

        .cta-section {
            padding: 8rem 0;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            text-align: center;
        }

        .cta-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .cta-title {
            font-size: 3rem;
            font-weight: 900;
            margin-bottom: 1.5rem;
        }

        .cta-subtitle {
            font-size: 1.3rem;
            opacity: 0.9;
            margin-bottom: 3rem;
            line-height: 1.6;
        }

        .cta-button {
            background: white;
            color: var(--primary-green);
            padding: 1.5rem 3rem;
            border: none;
            border-radius: 16px;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.8s ease-out;
        }

        @media (max-width: 1200px) {
            .hero-container {
                gap: 4rem;
            }
            
            .features-grid {
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 2rem;
            }

            .events-grid {
                grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
                gap: 2rem;
            }
        }

        @media (max-width: 968px) {
            .nav-links {
                display: none;
            }

            .hero-container {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 3rem;
            }

            .hero-title {
                font-size: 3rem;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-stats {
                justify-content: center;
            }

            .visual-grid {
                width: 400px;
                height: 400px;
            }

            .section-title {
                font-size: 2.5rem;
            }

            .cta-title {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .nav-container {
                padding: 0 1rem;
            }

            .hero-section {
                padding: 8rem 0 4rem;
            }

            .hero-container {
                padding: 0 1rem;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-buttons {
                flex-direction: column;
                gap: 1rem;
            }

            .hero-stats {
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }

            .visual-grid {
                width: 320px;
                height: 320px;
            }

            .features-container,
            .cta-container,
            .events-container {
                padding: 0 1rem;
            }

            .features-grid,
            .events-grid {
                grid-template-columns: 1fr;
            }

            .feature-card {
                padding: 2rem;
            }

            .event-card {
                margin: 0 auto;
                max-width: 400px;
            }

            .event-content {
                flex-direction: column;
                gap: 1rem;
            }

            .event-date {
                align-self: flex-start;
                min-width: 60px;
            }

            .event-actions {
                flex-direction: column;
                gap: 0.75rem;
            }

            .events-section {
                padding: 6rem 0;
            }

            .no-events {
                padding: 4rem 1rem;
            }
        }

        @media (max-width: 480px) {
            .user-menu {
                flex-direction: column;
                gap: 0.5rem;
            }

            .user-info {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
    <script>
        // Auto-hide flash messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessages = document.querySelectorAll('[style*="position: fixed"]');
            flashMessages.forEach(function(message) {
                setTimeout(function() {
                    message.style.opacity = '0';
                    message.style.transform = 'translateX(100%)';
                    message.style.transition = 'all 0.3s ease';
                    setTimeout(function() {
                        message.style.display = 'none';
                    }, 300);
                }, 5000);
            });
        });
    </script>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="logo">
                <i class="fas fa-leaf"></i>
                EcoEvents
            </a>
            <div class="nav-links">
                <a href="#features" class="nav-link">Fonctionnalités</a>
                <a href="{{ route('events.index') }}" class="nav-link">Événements</a>
                <a href="#" class="nav-link">Communauté</a>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.users.index') }}" class="nav-link">Administration</a>
                @endif
                <a href="#" class="nav-link">Dashboard</a>
            </div>
            <div class="user-menu">
                <div class="user-info">
                    <div class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <div>
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">{{ Auth::user()->getRoleDisplayName() }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="hero-container">
            <!-- Flash Messages -->
            @if(session('success'))
                <div style="position: fixed; top: 100px; right: 20px; z-index: 1050; background: linear-gradient(135deg, var(--secondary-green), var(--primary-green)); color: white; padding: 1rem 1.5rem; border-radius: 12px; box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3); max-width: 400px;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i>
                        <div>
                            <strong>Succès !</strong><br>
                            {{ session('success') }}
                        </div>
                        <button onclick="this.parentElement.parentElement.style.display='none'" style="background: none; border: none; color: white; font-size: 1.2rem; cursor: pointer; margin-left: auto;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif
            
            @if(session('error'))
                <div style="position: fixed; top: 100px; right: 20px; z-index: 1050; background: linear-gradient(135deg, #ef4444, #dc2626); color: white; padding: 1rem 1.5rem; border-radius: 12px; box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3); max-width: 400px;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-exclamation-circle" style="font-size: 1.2rem;"></i>
                        <div>
                            <strong>Erreur !</strong><br>
                            {{ session('error') }}
                        </div>
                        <button onclick="this.parentElement.parentElement.style.display='none'" style="background: none; border: none; color: white; font-size: 1.2rem; cursor: pointer; margin-left: auto;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif
            
            @if(session('warning'))
                <div style="position: fixed; top: 100px; right: 20px; z-index: 1050; background: linear-gradient(135deg, var(--accent-orange), #ea580c); color: white; padding: 1rem 1.5rem; border-radius: 12px; box-shadow: 0 8px 25px rgba(249, 115, 22, 0.3); max-width: 400px;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 1.2rem;"></i>
                        <div>
                            <strong>Attention !</strong><br>
                            {{ session('warning') }}
                        </div>
                        <button onclick="this.parentElement.parentElement.style.display='none'" style="background: none; border: none; color: white; font-size: 1.2rem; cursor: pointer; margin-left: auto;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif

            <div class="hero-content animate-fade-in">
                <div class="hero-badge">
                    <i class="fas fa-bolt"></i>
                    Plateforme Innovante
                </div>
                <h1 class="hero-title">
                    Organisez des événements
                    <span class="accent">éco-responsables</span>
                    qui font la différence
                </h1>
                <p class="hero-subtitle">
                    @if(Auth::user()->isAdmin())
                        En tant qu'administrateur, orchestrez l'écosystème complet d'EcoEvents. 
                        Supervisez les événements durables, gérez la communauté et analysez l'impact environnemental en temps réel.
                    @elseif(Auth::user()->isParticipant())
                        Découvrez des événements éco-responsables exceptionnels près de chez vous. 
                        Connectez-vous avec une communauté passionnée et contribuez à un avenir plus durable.
                    @elseif(Auth::user()->isVolunteer())
                        Transformez votre passion en action ! Organisez des événements durables 
                        et créez un impact positif mesurable dans votre communauté locale.
                    @else
                        La première plateforme collaborative pour créer, gérer et participer à des événements 
                        qui respectent notre planète et rassemblent les communautés.
                    @endif
                </p>
                <div class="hero-buttons">
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.users.index') }}" class="btn-primary">
                            <i class="fas fa-users-cog"></i>
                            Gérer la plateforme
                        </a>
                        <a href="#" class="btn-secondary">
                            <i class="fas fa-chart-line"></i>
                            Analytics avancés
                        </a>
                    @elseif(Auth::user()->isParticipant())
                        <a href="#" class="btn-primary">
                            <i class="fas fa-calendar-plus"></i>
                            Explorer les événements
                        </a>
                        <a href="#" class="btn-secondary">
                            <i class="fas fa-bookmark"></i>
                            Mes participations
                        </a>
                    @elseif(Auth::user()->isVolunteer())
                        <a href="#" class="btn-primary">
                            <i class="fas fa-hands-helping"></i>
                            Créer un événement
                        </a>
                        <a href="#" class="btn-secondary">
                            <i class="fas fa-tasks"></i>
                            Mes missions
                        </a>
                    @else
                        <a href="#" class="btn-primary">
                            <i class="fas fa-rocket"></i>
                            Commencer maintenant
                        </a>
                        <a href="#" class="btn-secondary">
                            <i class="fas fa-users"></i>
                            Rejoindre la communauté
                        </a>
                    @endif
                </div>
                <div class="hero-stats">
                    <div class="stat-card">
                        <span class="stat-number">{{ App\Models\User::count() }}</span>
                        <span class="stat-label">Membres actifs</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number">{{ App\Models\User::where('is_active', true)->count() }}</span>
                        <span class="stat-label">Événements créés</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number">98%</span>
                        <span class="stat-label">Satisfaction</span>
                    </div>
                </div>
            </div>

            <div class="hero-visual animate-fade-in">
                <div class="visual-grid">
                    <div class="visual-card main-visual">
                        <i class="fas fa-globe-americas"></i>
                        <h3>Impact Global</h3>
                        <p>Mesurez l'empreinte carbone réduite grâce à vos événements durables</p>
                    </div>
                    <div class="visual-card">
                        <i class="fas fa-calendar-check"></i>
                        <h3>Gestion Simple</h3>
                        <p>Outils intuitifs pour organiser facilement</p>
                    </div>
                    <div class="visual-card">
                        <i class="fas fa-users"></i>
                        <h3>Communauté</h3>
                        <p>Réseau engagé de participants actifs</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section class="events-section" id="events">
        <div class="events-container">
            <div class="section-header">
                <h2 class="section-title">Événements <span class="accent">Éco-responsables</span></h2>
                <p class="section-subtitle">
                    Découvrez les événements durables qui font la différence dans votre région
                </p>
            </div>
            
            @php
                $events = App\Models\Event::with(['category', 'venue', 'creator'])
                    ->where('status', 'published')
                    ->where('start_date', '>', now())
                    ->orderBy('start_date', 'asc')
                    ->limit(6)
                    ->get();
            @endphp
            
            @if($events->count() > 0)
                <div class="events-grid">
                    @foreach($events as $event)
                        <div class="event-card">
                            <div class="event-image">
                                @if($event->featured_image)
                                    <img src="{{ asset('storage/' . $event->featured_image) }}" alt="{{ $event->title }}">
                                @else
                                    <div class="event-placeholder">
                                        <i class="fas fa-calendar-alt"></i>
                                        <div class="placeholder-text">Événement</div>
                                    </div>
                                @endif
                                @if($event->is_featured)
                                    <div class="featured-badge">
                                        <i class="fas fa-star"></i>
                                        Événement vedette
                                    </div>
                                @endif
                                <div class="category-badge" style="background: {{ $event->category->color ?? '#059669' }}">
                                    @if($event->category->icon)
                                        <i class="fas {{ $event->category->icon }}"></i>
                                    @endif
                                    {{ $event->category->name ?? 'Événement' }}
                                </div>
                            </div>
                            
                            <div class="event-content">
                                <div class="event-date">
                                    <div class="date-day">{{ $event->start_date->format('d') }}</div>
                                    <div class="date-month">{{ $event->start_date->format('M') }}</div>
                                </div>
                                
                                <div class="event-info">
                                    <h3 class="event-title">{{ $event->title }}</h3>
                                    <p class="event-description">{{ Str::limit($event->short_description ?? $event->description, 120) }}</p>
                                    
                                    <div class="event-meta">
                                        <div class="event-location">
                                            <i class="fas fa-map-marker-alt"></i>
                                            {{ $event->venue->city ?? 'Lieu à définir' }}
                                        </div>
                                        <div class="event-participants">
                                            <i class="fas fa-users"></i>
                                            {{ $event->registrations()->where('status', 'approved')->count() }}/{{ $event->max_participants ?? '∞' }}
                                        </div>
                                        @if($event->price > 0)
                                            <div class="event-price">
                                                <i class="fas fa-euro-sign"></i>
                                                {{ number_format($event->price, 2) }}€
                                            </div>
                                        @else
                                            <div class="event-price free">
                                                <i class="fas fa-gift"></i>
                                                Gratuit
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="event-actions">
                                @if($event->isUserRegistered(Auth::id()))
                                    <button class="btn-registered" disabled>
                                        <i class="fas fa-check"></i>
                                        Inscrit
                                    </button>
                                @else
                                    <form method="POST" action="{{ route('events.register', $event->id) }}" style="flex: 1;">
                                        @csrf
                                        <input type="hidden" name="type" value="participant">
                                        <button type="submit" class="btn-register" style="width: 100%;">
                                            <i class="fas fa-calendar-plus"></i>
                                            S'inscrire
                                        </button>
                                    </form>
                                @endif
                                <a href="#" class="btn-details">
                                    <i class="fas fa-info-circle"></i>
                                    Détails
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="events-cta">
                    <a href="{{ route('events.index') }}" class="btn-see-all">
                        <i class="fas fa-calendar"></i>
                        Voir tous les événements
                    </a>
                </div>
            @else
                <div class="no-events">
                    <div class="no-events-icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <h3>Aucun événement à venir</h3>
                    <p>Les organisateurs préparent de nouveaux événements éco-responsables. Revenez bientôt !</p>
                    @if(Auth::user()->isVolunteer() || Auth::user()->isAdmin())
                        <a href="#" class="btn-create-event">
                            <i class="fas fa-plus"></i>
                            Créer un événement
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <section class="features-section" id="features">
        <div class="features-container">
            <div class="section-header">
                <h2 class="section-title">Fonctionnalités <span class="accent">Innovantes</span></h2>
                <p class="section-subtitle">
                    Découvrez les outils qui font d'EcoEvents la plateforme de référence 
                    pour l'organisation d'événements durables et impactants.
                </p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Calcul d'Impact Environnemental</h3>
                    <p>Mesurez automatiquement l'empreinte carbone de vos événements avec nos algorithmes avancés et obtenez des recommandations personnalisées pour réduire votre impact.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <h3>Réseau de Partenaires Locaux</h3>
                    <p>Connectez-vous avec des fournisseurs éco-responsables dans votre région. Traiteurs bio, lieux durables, transports verts - tout l'écosystème en un clic.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Analytics en Temps Réel</h3>
                    <p>Suivez les inscriptions, l'engagement et l'impact de vos événements avec des tableaux de bord interactifs et des rapports détaillés.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Application Mobile Native</h3>
                    <p>Gérez vos événements et restez connecté avec votre communauté où que vous soyez grâce à notre application mobile intuitive.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3>Système de Badges & Récompenses</h3>
                    <p>Motivez votre communauté avec un système de gamification qui récompense l'engagement environnemental et la participation active.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Conformité & Certifications</h3>
                    <p>Respectez automatiquement les normes environnementales et obtenez des certifications reconnues pour vos événements durables.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="cta-container">
            <h2 class="cta-title">Prêt à transformer vos événements ?</h2>
            <p class="cta-subtitle">
                Rejoignez des milliers d'organisateurs qui font déjà la différence. 
                Créez des événements mémorables qui respectent notre planète.
            </p>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.users.index') }}" class="cta-button">
                    <i class="fas fa-dashboard"></i>
                    Accéder au tableau de bord
                </a>
            @else
                <a href="#" class="cta-button">
                    <i class="fas fa-plus-circle"></i>
                    Créer mon premier événement
                </a>
            @endif
        </div>
    </section>
</body>
</html>