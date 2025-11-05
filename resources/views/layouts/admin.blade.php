<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Fintel') }} - @yield('title', 'Dashboard')</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; display: flex; min-height: 100vh; }

        .sidebar { width: 260px; background: linear-gradient(180deg, #667eea 0%, #764ba2 100%); color: white; padding: 0; position: fixed; inset: 0 auto 0 0; height: 100vh; overflow-y: auto; box-shadow: 2px 0 10px rgba(0,0,0,0.1); transition: transform .25s ease; }
        .sidebar.closed { transform: translateX(-100%); }
        .sidebar-header { padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,.2); display: flex; align-items: center; justify-content: space-between; }
        .sidebar-header h1 { font-size: 1.5rem; font-weight: 700; }
        .sidebar-header p { font-size: .85rem; opacity: .9; margin-top: 5px; }
        .sidebar-menu { padding: 16px 0; }
        .menu-item { display: block; padding: 14px 22px; color: white; text-decoration: none; transition: all .2s ease; border-left: 4px solid transparent; }
        .menu-item:hover { background: rgba(255,255,255,.1); border-left-color: white; padding-left: 26px; }
        .menu-item.active { background: rgba(255,255,255,.2); border-left-color: white; }
        .sidebar-footer { position: sticky; bottom: 0; width: 100%; padding: 16px 20px; border-top: 1px solid rgba(255,255,255,.2); background: linear-gradient(180deg, rgba(0,0,0,.0), rgba(0,0,0,.05)); }
        .user-info { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,.2); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.1rem; }
        .btn-logout { width: 100%; padding: 10px; background: rgba(255,255,255,.2); color: white; border: 1px solid rgba(255,255,255,.3); border-radius: 8px; cursor: pointer; font-weight: 600; transition: all .2s ease; }
        .btn-logout:hover { background: rgba(255,255,255,.3); }

        .main-content { margin-left: 260px; flex: 1; min-height: 100vh; display: flex; flex-direction: column; }
        .top-header { background: white; padding: 14px 16px; box-shadow: 0 2px 5px rgba(0,0,0,.05); display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 2; }
        .page-title { font-size: 1.3rem; color: #333; font-weight: 700; }
        .mobile-toggle { display: none; border: none; background: transparent; font-size: 1.4rem; padding: 8px; cursor: pointer; }
        .content-area { padding: 16px; }

        @media (max-width: 992px) {
            body { overflow-x: hidden; }
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .top-header { padding: 12px 14px; }
            .page-title { font-size: 1.1rem; }
            .mobile-toggle { display: inline-block; color: #667eea; }
        }

        @media (max-width: 480px) {
            .sidebar-header h1 { font-size: 1.25rem; }
            .menu-item { padding: 12px 18px; }
            .content-area { padding: 12px; }
        }
    </style>
</head>
<body>
    <div class="sidebar closed" id="sidebar">
        <div class="sidebar-header">
            <div>
                <h1>🚀 Fintel</h1>
                <p>Interface Admin</p>
            </div>
            <button class="mobile-toggle" aria-label="Fermer" onclick="toggleSidebar()">✕</button>
        </div>
        <nav class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 Dashboard</a>
            <a href="{{ route('admin.users') }}" class="menu-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">👥 Utilisateurs</a>
            <a href="{{ route('admin.transactions') }}" class="menu-item {{ request()->routeIs('admin.transactions') ? 'active' : '' }}">💰 Transactions</a>
        </nav>
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ substr(Auth::guard('admin')->user()->first_name ?? 'A', 0, 1) }}</div>
                <div>
                    <div class="user-name">{{ Auth::guard('admin')->user()->first_name ?? 'Admin' }} {{ Auth::guard('admin')->user()->last_name ?? '' }}</div>
                    <div class="user-role">Administrateur</div>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">🚪 Déconnexion</button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="top-header">
            <button class="mobile-toggle" aria-label="Menu" onclick="toggleSidebar()">☰</button>
            <h2 class="page-title">@yield('page-title', 'Dashboard')</h2>
            <div style="width:40px"></div>
        </div>
        <div class="content-area">
            @if(session('success'))
                <div style="padding: 12px; background: #d4edda; border: 1px solid #c3e6cb; color: #155724; border-radius: 8px; margin-bottom: 14px;">
                    {{ session('success') }}
                </div>
            @endif
            @yield('content')
        </div>
    </div>

    <script>
        function toggleSidebar(){
            var el = document.getElementById('sidebar');
            if(!el) return;
            if(el.classList.contains('open')){
                el.classList.remove('open');
                el.classList.add('closed');
            } else {
                el.classList.remove('closed');
                el.classList.add('open');
            }
        }
    </script>
</body>
</html>

