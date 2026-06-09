<header class="m-nav">
    <div class="container m-nav__inner">
        <a href="{{ route('home') }}" class="brand" aria-label="{{ config('site.name') }} home">
            <span class="brand__mark" aria-hidden="true"></span>
            <span>{{ config('site.name') }}</span>
        </a>
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
    <a href="{{ route('contact') }}" class="btn btn--primary">Partner with us</a>
</div>
