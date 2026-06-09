<section class="page-head">
    <div class="container">
        <span class="eyebrow" data-reveal>Capabilities</span>
        <h1 data-reveal>Frontier capability, deployed into real operations.</h1>
        <p data-reveal>We don't sell slideware. Every discipline below runs live inside the
            companies we power.</p>
    </div>
</section>

<section class="section--tight">
    <div class="container">
        <div class="grid grid--2">
            @foreach($capabilities as $cap)
                <article class="card" data-reveal style="transition-delay: {{ $loop->index * 60 }}ms">
                    <div class="card__icon">@include('partials.icon', ['name' => $cap->icon])</div>
                    <h3>{{ $cap->title }}</h3>
                    <p>{{ $cap->summary }}</p>
                    @if($cap->body)
                        <p style="margin-top:14px;color:var(--text-faint)">{{ $cap->body }}</p>
                    @endif
                </article>
            @endforeach
        </div>
    </div>
</section>

@include('partials.investor-cta')
