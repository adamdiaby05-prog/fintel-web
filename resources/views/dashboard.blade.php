<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - Fintel</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .header { background: white; padding: 16px 18px; box-shadow: 0 2px 10px rgba(0,0,0,.1); display: flex; justify-content: space-between; align-items: center; gap: 16px; }
        .logo { font-size: 1.6rem; font-weight: 700; color: #667eea; }
        .user-info { display: flex; align-items: center; gap: 14px; }
        .user-details { text-align: right; }
        .user-name { font-weight: 600; color: #333; }
        .user-phone { color: #666; font-size: .9rem; }
        .btn-logout { padding: 10px 14px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: transform .15s ease; }
        .btn-logout:hover { transform: translateY(-1px); }
        .container { max-width: 1100px; margin: 28px auto; padding: 0 16px; }
        .welcome-card { background: white; border-radius: 16px; padding: 28px; box-shadow: 0 10px 30px rgba(0,0,0,.2); }
        .welcome-title { font-size: 2rem; color: #333; margin-bottom: 12px; }
        .welcome-subtitle { font-size: 1.05rem; color: #666; margin-bottom: 22px; }
        .info-box { background: #f8f9fa; border-left: 4px solid #667eea; padding: 18px; border-radius: 10px; margin-top: 22px; }
        .info-box h3 { color: #667eea; margin-bottom: 12px; }
        .info-box p { color: #666; line-height: 1.6; }
        .alert { padding: 12px; border-radius: 10px; margin-bottom: 16px; font-size: .95rem; }
        .alert-success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }

        @media (max-width: 768px) {
            .header { flex-direction: column; align-items: flex-start; gap: 10px; }
            .user-info { width: 100%; justify-content: space-between; }
            .user-details { text-align: left; }
            .logo { font-size: 1.4rem; }
            .container { margin: 20px auto; }
            .welcome-card { padding: 20px; border-radius: 14px; }
            .welcome-title { font-size: 1.6rem; }
        }

        @media (max-width: 480px) {
            .btn-logout { padding: 9px 12px; font-size: .95rem; }
            .welcome-card { padding: 16px; border-radius: 12px; }
            .welcome-title { font-size: 1.4rem; }
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
            <div class="alert alert-success">{{ session('success') }}</div>
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

