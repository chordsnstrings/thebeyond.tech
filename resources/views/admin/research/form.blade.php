@extends('admin.layout', ['title' => 'Article'])

@section('content')
    @php($editing = $article->exists)
    <div class="admin__head">
        <h1 class="admin__title">{{ $editing ? 'Edit article' : 'New article' }}</h1>
        <a href="{{ route('admin.research.index') }}" class="btn btn--ghost">Back</a>
    </div>

    @if($errors->any())
        <div class="alert alert--err">{{ $errors->first() }}</div>
    @endif

    <form action="{{ $editing ? route('admin.research.update', $article) : route('admin.research.store') }}" method="POST" style="max-width:760px">
        @csrf
        @if($editing) @method('PUT') @endif

        <div class="field"><label>Title</label>
            <input type="text" name="title" value="{{ old('title', $article->title) }}" required></div>

        <div class="field"><label>Slug (optional)</label>
            <input type="text" name="slug" value="{{ old('slug', $article->slug) }}" placeholder="auto from title"></div>

        <div class="grid grid--2" style="gap:16px">
            <div class="field"><label>Category</label>
                <input type="text" name="category" value="{{ old('category', $article->category ?? 'Research') }}" required></div>
            <div class="field"><label>Author</label>
                <input type="text" name="author" value="{{ old('author', $article->author ?? 'Beyond Research') }}" required></div>
        </div>

        <div class="field"><label>Excerpt</label>
            <textarea name="excerpt" style="min-height:90px" required>{{ old('excerpt', $article->excerpt) }}</textarea></div>

        <div class="field"><label>Body (HTML)</label>
            <textarea name="body" style="min-height:280px;font-family:var(--font-mono);font-size:13px" required>{{ old('body', $article->body) }}</textarea></div>

        <div class="grid grid--2" style="gap:16px">
            <div class="field"><label>Cover image URL</label>
                <input type="text" name="cover_image" value="{{ old('cover_image', $article->cover_image) }}"></div>
            <div class="field"><label>Read minutes</label>
                <input type="number" name="read_minutes" value="{{ old('read_minutes', $article->read_minutes ?? 5) }}" min="1" max="60" required></div>
        </div>

        <div class="field"><label>Meta description (SEO)</label>
            <input type="text" name="meta_description" value="{{ old('meta_description', $article->meta_description) }}"></div>

        <div class="field"><label>Keywords (comma separated, for SEO/LLM context)</label>
            <input type="text" name="keywords" value="{{ old('keywords', $article->keywords) }}"></div>

        <div class="field"><label>Key takeaways (one per line — renders a summary box + helps LLM extraction)</label>
            <textarea name="key_takeaways" style="min-height:120px">{{ old('key_takeaways', collect($article->key_takeaways ?? [])->implode("\n")) }}</textarea></div>

        <div class="field"><label>FAQs (one per line, format: Question :: Answer — powers FAQ rich results)</label>
            <textarea name="faqs" style="min-height:140px">{{ old('faqs', collect($article->faqs ?? [])->map(fn($f) => ($f['q'] ?? '').' :: '.($f['a'] ?? ''))->implode("\n")) }}</textarea></div>

        <div class="field"><label>Publish date</label>
            <input type="datetime-local" name="published_at"
                   value="{{ old('published_at', optional($article->published_at)->format('Y-m-d\TH:i')) }}"></div>

        <label style="display:flex;gap:8px;align-items:center;margin:8px 0 22px;color:var(--text-dim)">
            <input type="checkbox" name="is_published" value="1" style="width:auto" @checked(old('is_published', $article->is_published ?? false))> Published
        </label>

        <button type="submit" class="btn btn--primary">{{ $editing ? 'Save changes' : 'Create article' }}</button>
    </form>
@endsection
