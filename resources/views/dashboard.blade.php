<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - Fintel</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .header {
            background: white;
            padding: 20px 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 2rem;
            font-weight: 700;
            color: #667eea;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-details {
            text-align: right;
        }

        .user-name {
            font-weight: 600;
            color: #333;
        }

        .user-phone {
            color: #666;
            font-size: 0.9rem;
        }

        .btn-logout {
            padding: 10px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .welcome-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .welcome-title {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 15px;
        }

        .welcome-subtitle {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 30px;
        }

        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
        }

        .info-box h3 {
            color: #667eea;
            margin-bottom: 15px;
        }

        .info-box p {
            color: #666;
            line-height: 1.6;
        }

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">Fintel</div>
        <div class="user-info">
            <div class="user-details">
                <div class="user-name">{{ Auth::user()->first_name ?? 'Utilisateur' }} {{ Auth::user()->last_name ?? '' }}</div>
                <div class="user-phone">{{ Auth::user()->phone_number }}</div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">Déconnexion</button>
            </form>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="welcome-card">
            <h1 class="welcome-title">Bienvenue, {{ Auth::user()->first_name ?? 'Utilisateur' }} !</h1>
            <p class="welcome-subtitle">Vous êtes connecté à votre compte Fintel</p>

            <div class="info-box">
                <h3>Informations du compte</h3>
                <p><strong>Numéro de téléphone:</strong> {{ Auth::user()->phone_number }}</p>
                @if(Auth::user()->email)
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                @endif
                <p><strong>Statut:</strong> 
                    @if(Auth::user()->is_verified)
                        <span style="color: green;">✓ Vérifié</span>
                    @else
                        <span style="color: orange;">En attente de vérification</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</body>
</html>

