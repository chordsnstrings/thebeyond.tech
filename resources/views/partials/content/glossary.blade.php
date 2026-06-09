<section class="page-head">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <span>Glossary</span>
        </nav>
        <span class="eyebrow" data-reveal>Glossary</span>
        <h1 data-reveal>The language of AI, mobility and migration.</h1>
        <p data-reveal>Plain-English definitions of the terms that come up across our work — applied
            AI, EV charging, electric mobility, data and UAE relocation.</p>
    </div>
</section>

<section class="section--tight">
    <div class="container">
        <dl class="glossary">
            @foreach($terms as $t)
                <div class="glossary__item" id="{{ \Illuminate\Support\Str::slug($t['term']) }}" data-reveal>
                    <dt>{{ $t['term'] }}</dt>
                    <dd>
                        {{ $t['definition'] }}
                        @isset($t['link'])
                            <a href="{{ $t['link'] }}" class="glossary__more">Read more →</a>
                        @endisset
                    </dd>
                </div>
            @endforeach
        </dl>
    </div>
</section>

@include('partials.investor-cta')
