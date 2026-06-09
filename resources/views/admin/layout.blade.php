<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <title>{{ $title ?? 'Admin' }} — {{ config('site.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        .admin { display:grid; grid-template-columns: 240px 1fr; min-height:100vh; }
        .admin__side { border-right:1px solid var(--surface-line); padding:24px 18px; position:sticky; top:0; height:100vh; }
        .admin__side a { display:block; padding:10px 12px; border-radius:8px; color:var(--text-dim); font-size:14.5px; }
        .admin__side a:hover, .admin__side a.is-active { background:rgba(255,255,255,.05); color:var(--text); }
        .admin__main { padding:32px clamp(20px,4vw,48px); max-width:1100px; }
        .admin__head { display:flex; justify-content:space-between; align-items:center; margin-bottom:28px; gap:16px; flex-wrap:wrap; }
        .admin__title { font-family:var(--font-display); font-size:26px; font-weight:600; }
        table.admin-table { width:100%; border-collapse:collapse; font-size:14.5px; }
        table.admin-table th, table.admin-table td { text-align:left; padding:12px 10px; border-bottom:1px solid var(--surface-line); }
        table.admin-table th { font-family:var(--font-mono); font-size:11.5px; letter-spacing:.08em; text-transform:uppercase; color:var(--text-faint); }
        .pill { font-family:var(--font-mono); font-size:11px; padding:3px 9px; border-radius:999px; border:1px solid var(--surface-line-strong); }
        .pill--on { color:var(--accent); border-color:rgba(94,234,212,.4); }
        .row-actions a, .row-actions button { font-size:13px; color:var(--text-dim); margin-right:12px; background:none; border:none; cursor:pointer; }
        .row-actions a:hover { color:var(--accent); }
        .admin-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:16px; }
        .stat { border:1px solid var(--surface-line); border-radius:var(--radius); padding:20px; background:var(--bg-elev); }
        .stat b { font-family:var(--font-display); font-size:30px; display:block; }
        .stat span { color:var(--text-faint); font-family:var(--font-mono); font-size:12px; }
        @media (max-width:760px){ .admin{ grid-template-columns:1fr; } .admin__side{ position:static; height:auto; } }
    </style>
</head>
<body>
<div class="admin">
    <aside class="admin__side">
        <a href="{{ route('admin.dashboard') }}" class="brand" style="margin-bottom:24px">
            <span class="brand__mark" aria-hidden="true"></span> {{ config('site.name') }}
        </a>
        @php($nav = [
            'admin.dashboard' => 'Dashboard',
            'admin.research.index' => 'Research',
            'admin.portfolio.index' => 'Portfolio',
            'admin.capabilities.index' => 'Capabilities',
            'admin.submissions.index' => 'Submissions',
        ])
        @foreach($nav as $route => $label)
            <a href="{{ route($route) }}" class="{{ request()->routeIs(str_replace('.index','',$route).'*') ? 'is-active' : '' }}">{{ $label }}</a>
        @endforeach
        <form action="{{ route('admin.logout') }}" method="POST" style="margin-top:24px">
            @csrf
            <button type="submit" class="btn btn--ghost" style="width:100%;justify-content:center">Log out</button>
        </form>
        <a href="{{ route('home') }}" target="_blank" style="margin-top:12px;font-size:13px;color:var(--text-faint)">View site ↗</a>
    </aside>

    <main class="admin__main">
        @if(session('status'))
            <div class="alert alert--ok">{{ session('status') }}</div>
        @endif
        @yield('content')
    </main>
</div>
</body>
</html>
