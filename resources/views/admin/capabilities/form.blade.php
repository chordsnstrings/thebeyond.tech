@extends('admin.layout', ['title' => 'Capability'])

@section('content')
    @php($editing = $capability->exists)
    <div class="admin__head">
        <h1 class="admin__title">{{ $editing ? 'Edit capability' : 'New capability' }}</h1>
        <a href="{{ route('admin.capabilities.index') }}" class="btn btn--ghost">Back</a>
    </div>

    @if($errors->any())
        <div class="alert alert--err">{{ $errors->first() }}</div>
    @endif

    <form action="{{ $editing ? route('admin.capabilities.update', $capability) : route('admin.capabilities.store') }}" method="POST" style="max-width:680px">
        @csrf
        @if($editing) @method('PUT') @endif

        <div class="field"><label>Title</label>
            <input type="text" name="title" value="{{ old('title', $capability->title) }}" required></div>

        <div class="grid grid--2" style="gap:16px">
            <div class="field"><label>Slug (optional)</label>
                <input type="text" name="slug" value="{{ old('slug', $capability->slug) }}" placeholder="auto from title"></div>
            <div class="field"><label>Icon</label>
                <select name="icon">
                    @foreach(['ai','research','engineering','data'] as $icon)
                        <option value="{{ $icon }}" @selected(old('icon', $capability->icon) === $icon)>{{ $icon }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="field"><label>Summary</label>
            <textarea name="summary" style="min-height:90px" required>{{ old('summary', $capability->summary) }}</textarea></div>

        <div class="field"><label>Body (optional)</label>
            <textarea name="body" style="min-height:140px">{{ old('body', $capability->body) }}</textarea></div>

        <div class="field"><label>Sort order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $capability->sort_order ?? 0) }}" min="0"></div>

        <label style="display:flex;gap:8px;align-items:center;margin:8px 0 22px;color:var(--text-dim)">
            <input type="checkbox" name="is_published" value="1" style="width:auto" @checked(old('is_published', $capability->is_published ?? true))> Published
        </label>

        <button type="submit" class="btn btn--primary">{{ $editing ? 'Save changes' : 'Create capability' }}</button>
    </form>
@endsection
