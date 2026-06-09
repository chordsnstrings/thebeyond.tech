@php
    // Build per-letter spans (.ch) for the cursor-reactive effect, grouped into
    // non-breaking word spans so the headline wraps at spaces — never mid-word.
    $letters = function (string $text, bool $accent = false) {
        $cls = 'ch'.($accent ? ' accent' : '');
        $words = preg_split('/\s+/u', trim($text), -1, PREG_SPLIT_NO_EMPTY);
        $out = [];
        foreach ($words as $word) {
            $chars = '';
            foreach (preg_split('//u', $word, -1, PREG_SPLIT_NO_EMPTY) as $ch) {
                $chars .= '<span class="'.$cls.'">'.e($ch).'</span>';
            }
            $out[] = '<span class="word">'.$chars.'</span>';
        }
        return implode(' ', $out);
    };
@endphp

<section class="hero" data-hero>
    <canvas class="hero__canvas" aria-hidden="true"></canvas>
    <div class="container hero__inner">
        <span class="eyebrow hero__eyebrow" data-reveal>ARKS Groups · Technology, AI &amp; Research</span>

        <h1 class="hero__title" aria-label="We engineer what comes next.">
            {!! $letters('We engineer') !!} {!! $letters('what comes') !!} {!! $letters('next.', true) !!}
        </h1>

        <p class="hero__sub" data-reveal>
            Beyond is the in-house AI, research and engineering studio behind ARKS Groups —
            building the intelligent platforms and data systems that run our portfolio across
            mobility, energy, migration and wellness.
        </p>

        <div class="hero__actions" data-reveal>
            <a href="{{ route('capabilities') }}" class="btn btn--primary">
                Explore capabilities @include('partials.icon', ['name' => 'arrow'])
            </a>
            <a href="{{ route('contact') }}" class="btn btn--ghost">For investors</a>
        </div>

        <div class="hero__meta" data-reveal>
            <div><b>4</b> sectors powered</div>
            <div><b>1</b> technology engine</div>
            <div><b>AI</b> in production</div>
            <div><b>Dubai</b> headquartered</div>
        </div>
    </div>
</section>
