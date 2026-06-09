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
    </div>
</header>
