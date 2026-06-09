<section class="page-head">
    <div class="container">
        <span class="eyebrow" data-reveal>Research &amp; insights</span>
        <h1 data-reveal>Perspectives on AI, data and engineering.</h1>
        <p data-reveal>Applied research from the team building the ARKS technology stack.</p>
    </div>
</section>

<section class="section--tight">
    <div class="container">
        @if($articles->count())
            <div class="grid grid--3">
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
            <p class="lead">New research is on the way.</p>
        @endif
    </div>
</section>
