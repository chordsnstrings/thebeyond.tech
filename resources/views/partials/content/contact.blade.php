<section class="page-head">
    <div class="container">
        <span class="eyebrow" data-reveal>Contact</span>
        <h1 data-reveal>Partner with Beyond.</h1>
        <p data-reveal>For investment conversations, partnerships or senior technical roles —
            reach the team directly.</p>
    </div>
</section>

<section class="section--tight">
    <div class="container">
        <div class="grid grid--2" style="align-items:start;gap:48px">
            <div data-reveal>
                <h3 style="font-family:var(--font-display);font-size:22px">Direct</h3>
                <p class="lead" style="margin-top:14px">
                    <a href="mailto:{{ config('site.email') }}" style="color:var(--accent)">{{ config('site.email') }}</a>
                </p>
                <p style="margin-top:20px;color:var(--text-dim)">{{ config('site.location') }}</p>
                <p style="margin-top:8px;color:var(--text-faint);font-family:var(--font-mono);font-size:13px">
                    A subsidiary of {{ config('site.parent.name') }}
                </p>

                <div style="margin-top:40px">
                    @foreach(config('site.socials') as $label => $url)
                        <a href="{{ $url }}" target="_blank" rel="noopener" class="tag" style="margin-right:8px">{{ $label }} ↗</a>
                    @endforeach
                </div>
            </div>

            <div class="card" data-reveal>
                @include('partials.contact-form')
            </div>
        </div>
    </div>
</section>
