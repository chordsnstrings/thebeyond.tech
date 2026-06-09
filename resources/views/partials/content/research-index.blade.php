<section class="page-head">
    <div class="container">
        <span class="eyebrow" data-reveal>Research &amp; insights</span>
        <h1 data-reveal>Guides &amp; perspectives on AI, mobility and beyond.</h1>
        <p data-reveal>Practical research from the team building the ARKS technology stack —
            covering applied AI, electric mobility, EV charging, relocation technology and data.</p>
    </div>
</section>

<section class="section--tight">
    <div class="container">
        <form action="{{ route('research.index') }}" method="GET" class="research-filter" role="search">
            <input type="search" name="q" value="{{ $query ?? '' }}" placeholder="Search research…" aria-label="Search research">
            <button type="submit" class="btn btn--ghost">Search</button>
        </form>

        @isset($categories)
            <div class="chips" data-reveal>
                <a href="{{ route('research.index') }}" class="chip {{ empty($category) ? 'is-active' : '' }}">All</a>
                @foreach($categories as $cat)
                    <a href="{{ route('research.index', ['category' => $cat]) }}"
                       class="chip {{ ($category ?? '') === $cat ? 'is-active' : '' }}">{{ $cat }}</a>
                @endforeach
            </div>
        @endisset

        @if($articles->count())
            <div class="grid grid--3" style="margin-top:32px">
                @foreach($articles as $article)
                    <a class="card article-card" href="{{ route('research.show', $article) }}" data-reveal>
                        <div class="article-card__meta">
                            <span>{{ $article->category }}</span>
                            <span>{{ $article->published_at?->format('M Y') }}</span>
                            <span>{{ $article->read_minutes }} min</span>
                        </div>
                        <h3>{{ $article->title }}</h3>
                        <p class="article-card__excerpt">{{ $article->excerpt }}</p>
                        <span class="article-card__more">Read →</span>
                    </a>
                @endforeach
            </div>

            <div style="margin-top:40px">{{ $articles->links() }}</div>
        @else
            <p class="lead" style="margin-top:32px">No articles match “{{ $query }}”. Try a broader term.</p>
        @endif
    </div>
</section>
