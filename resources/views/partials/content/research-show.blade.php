@push('meta')
    <meta property="article:published_time" content="{{ $article->published_at?->toIso8601String() }}">
    <meta property="article:modified_time" content="{{ $article->updated_at?->toIso8601String() }}">
    <meta property="article:section" content="{{ $article->category }}">
    @if($article->keywords)<meta name="keywords" content="{{ $article->keywords }}">@endif
@endpush

<article>
    <section class="page-head">
        <div class="container" style="max-width:820px">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span>/</span>
                <a href="{{ route('research.index') }}">Research</a>
                <span>/</span>
                <span>{{ $article->category }}</span>
            </nav>
            <span class="eyebrow">{{ $article->category }} · {{ $article->read_minutes }} min read</span>
            <h1>{{ $article->title }}</h1>
            <p class="article-byline">
                {{ $article->author }} · Published {{ $article->published_at?->format('F j, Y') }}
                @if($article->updated_at && $article->updated_at->gt($article->published_at))
                    · Updated {{ $article->updated_at->format('F j, Y') }}
                @endif
            </p>
        </div>
    </section>

    <section class="section--tight">
        <div class="container">
            <div class="prose">
                <div class="quick-answer" aria-label="Quick answer">
                    <span class="quick-answer__label">Quick answer</span>
                    <p>{{ $article->excerpt }}</p>
                </div>

                @if(!empty($article->key_takeaways))
                    <aside class="takeaways" aria-label="Key takeaways">
                        <h2 style="margin-top:0">Key takeaways</h2>
                        <ul>
                            @foreach($article->key_takeaways as $point)
                                <li>{{ $point }}</li>
                            @endforeach
                        </ul>
                    </aside>
                @endif

                {!! $article->body !!}

                @if(!empty($article->faqs))
                    <section class="faq" aria-label="Frequently asked questions">
                        <h2>Frequently asked questions</h2>
                        @foreach($article->faqs as $faq)
                            <details>
                                <summary>{{ $faq['q'] }}</summary>
                                <p>{{ $faq['a'] }}</p>
                            </details>
                        @endforeach
                    </section>
                @endif
            </div>
        </div>
    </section>

    @if($related->isNotEmpty())
        <section class="section--tight">
            <div class="container">
                <div class="section-head"><span class="eyebrow">Related research</span></div>
                <div class="grid grid--3">
                    @foreach($related as $r)
                        <a class="card article-card" href="{{ route('research.show', $r) }}">
                            <div class="article-card__meta">
                                <span>{{ $r->category }}</span>
                                <span>{{ $r->read_minutes }} min</span>
                            </div>
                            <h3>{{ $r->title }}</h3>
                            <p class="article-card__excerpt">{{ $r->excerpt }}</p>
                            <span class="article-card__more">Read →</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="section--tight">
        <div class="container">
            <a href="{{ route('research.index') }}" class="btn btn--ghost">← All research</a>
        </div>
    </section>
</article>

@include('partials.investor-cta')
