<!DOCTYPE html>
<html lang="en" class="theme-dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#08090c">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="apple-touch-icon" href="/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    @include('partials.meta')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')

    {{-- Scroll-reveal content is hidden until JS adds .is-visible; reveal it when JS is unavailable. --}}
    <noscript>
        <style>[data-reveal]{opacity:1!important;transform:none!important}</style>
    </noscript>
</head>
<body>
    @include('partials.nav-mobile')

    <main id="main">
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>
