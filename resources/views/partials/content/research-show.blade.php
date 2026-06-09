<article>
    <section class="page-head">
        <div class="container" style="max-width:820px">
            <span class="eyebrow">{{ $article->category }} · {{ $article->read_minutes }} min read</span>
            <h1>{{ $article->title }}</h1>
            <p style="font-family:var(--font-mono);font-size:13px;color:var(--text-faint)">
                {{ $article->author }} · {{ $article->published_at?->format('F j, Y') }}
            </p>
        </div>
    </section>

    <section class="section--tight">
        <div class="container">
            <div class="prose">
                {!! $article->body !!}
            </div>
        </div>
    </section>

    <section class="section--tight">
        <div class="container">
            <a href="{{ route('research.index') }}" class="btn btn--ghost">← All research</a>
        </div>
    </section>
</article>

@include('partials.investor-cta')
