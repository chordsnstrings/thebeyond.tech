<section class="section" id="research">
    <div class="container">
        <div class="section-head" data-reveal>
            <span class="eyebrow">Research &amp; insights</span>
            <h2>Notes from the team building the stack.</h2>
        </div>

        <div class="grid grid--3">
            @foreach($articles as $article)
                <a class="card article-card" href="{{ route('research.show', $article) }}" data-reveal
                   style="transition-delay: {{ $loop->index * 60 }}ms">
                    <div class="article-card__meta">
                        <span>{{ $article->category }}</span>
                        <span>{{ $article->read_minutes }} min</span>
                    </div>
                    <h3>{{ $article->title }}</h3>
                    <p class="article-card__excerpt">{{ $article->excerpt }}</p>
                    <span class="article-card__more">Read →</span>
                </a>
            @endforeach
        </div>
    </div>
</section>
