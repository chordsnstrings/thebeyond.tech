<header class="nav">
    <div class="container nav__inner">
        <a href="{{ route('home') }}" class="brand" aria-label="{{ config('site.name') }} home">
            <span class="brand__mark" aria-hidden="true"></span>
            <span>{{ config('site.name') }}<br><small>by ARKS Groups</small></span>
        </a>

        <nav class="nav__links" aria-label="Primary">
            @foreach(config('site.nav') as $item)
                <a href="{{ route($item['route']) }}"
                   class="{{ request()->routeIs($item['route']) ? 'is-active' : '' }}">{{ $item['label'] }}</a>
            @endforeach
            <a href="{{ route('contact') }}" class="btn btn--primary nav__cta">
                Partner with us
                @include('partials.icon', ['name' => 'arrow'])
            </a>
        </nav>

        {{-- Shown only at narrow widths (tablets / small windows) via CSS --}}
        <button class="nav__toggle" data-nav-toggle aria-label="Open menu" aria-expanded="false">
            <span></span>
        </button>
    </div>
</header>

<div class="m-drawer" data-nav-drawer>
    <button class="m-drawer__close" data-nav-toggle aria-label="Close menu">×</button>
    <a href="{{ route('home') }}">Home</a>
    @foreach(config('site.nav') as $item)
        <a href="{{ route($item['route']) }}">{{ $item['label'] }}</a>
    @endforeach
    <a href="{{ route('glossary') }}">Glossary</a>
    <a href="{{ route('contact') }}" class="btn btn--primary">Partner with us</a>
</div>
