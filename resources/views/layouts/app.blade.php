<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Fintel') }} - @yield('title', 'Accueil')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 16px; }
        .container { background: white; border-radius: 16px; box-shadow: 0 16px 48px rgba(0, 0, 0, 0.25); overflow: hidden; width: 100%; max-width: 460px; padding: 28px; }
        .logo { text-align: center; margin-bottom: 20px; }
        .logo h1 { color: #667eea; font-size: 2rem; font-weight: 700; margin-bottom: 8px; }
        .logo p { color: #666; font-size: .95rem; }
        .form-group { margin-bottom: 16px; }
        label { display: block; margin-bottom: 8px; color: #333; font-weight: 500; font-size: .95rem; }
        input[type="text"], input[type="email"], input[type="password"], input[type="tel"] { width: 100%; padding: 12px 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all .2s ease; background: #f8f9fa; }
        input:focus { outline: none; border-color: #667eea; background: white; }
        .btn { width: 100%; padding: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; font-size: 1.05rem; font-weight: 600; cursor: pointer; transition: transform .15s ease; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 5px 14px rgba(102,126,234,.35); }
        .btn:active { transform: translateY(0); }
        .link { text-align: center; margin-top: 16px; }
        .link a { color: #667eea; text-decoration: none; font-weight: 500; }
        .link a:hover { text-decoration: underline; }
        .alert { padding: 12px; border-radius: 10px; margin-bottom: 16px; font-size: .95rem; }
        .alert-success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .alert-error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        .error-list { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 12px; border-radius: 10px; margin-bottom: 16px; font-size: .95rem; }
        .error-list ul { margin-left: 20px; }
        .error-list li { margin-bottom: 4px; }
        .checkbox-group { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }
        .checkbox-group input[type="checkbox"] { width: auto; cursor: pointer; }
        input.error { border-color: #dc3545; background: #fff5f5; }
        .error-message { color: #dc3545; font-size: .85rem; margin-top: 6px; display: block; }

        @media (max-width: 768px) {
            body { padding: 12px; }
            .container { padding: 22px; border-radius: 14px; box-shadow: 0 12px 32px rgba(0,0,0,.22); }
            .logo h1 { font-size: 1.7rem; }
            .btn { font-size: 1rem; padding: 12px; }
        }

        @media (max-width: 480px) {
            .container { padding: 18px; border-radius: 12px; }
            .logo { margin-bottom: 14px; }
            .logo h1 { font-size: 1.5rem; }
            label { font-size: .9rem; }
            input[type="text"], input[type="email"], input[type="password"], input[type="tel"] { padding: 11px 12px; font-size: .95rem; }
            .btn { font-size: .98rem; padding: 11px; }
        }
    </style>
</head>
<body>
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="error-list">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>

