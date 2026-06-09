<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin — {{ config('site.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body>
<div style="min-height:100vh;display:grid;place-items:center;padding:24px">
    <div class="card" style="width:100%;max-width:400px">
        <a href="{{ route('home') }}" class="brand" style="margin-bottom:20px">
            <span class="brand__mark" aria-hidden="true"></span> {{ config('site.name') }}
        </a>
        <h1 style="font-family:var(--font-display);font-size:24px;margin-bottom:6px">Admin sign in</h1>
        <p style="color:var(--text-faint);font-size:14px;margin-bottom:22px">Content management</p>

        @if($errors->any())
            <div class="alert alert--err">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('admin.login.attempt') }}" method="POST">
            @csrf
            <div class="field">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>
            <label style="display:flex;gap:8px;align-items:center;font-size:13px;color:var(--text-dim);margin-bottom:18px">
                <input type="checkbox" name="remember" style="width:auto"> Remember me
            </label>
            <button type="submit" class="btn btn--primary" style="width:100%;justify-content:center">Sign in</button>
        </form>
    </div>
</div>
</body>
</html>
