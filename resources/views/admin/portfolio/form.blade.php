@extends('admin.layout', ['title' => 'Company'])

@section('content')
    @php($editing = $company->exists)
    <div class="admin__head">
        <h1 class="admin__title">{{ $editing ? 'Edit company' : 'New company' }}</h1>
        <a href="{{ route('admin.portfolio.index') }}" class="btn btn--ghost">Back</a>
    </div>

    @if($errors->any())
        <div class="alert alert--err">{{ $errors->first() }}</div>
    @endif

    <form action="{{ $editing ? route('admin.portfolio.update', $company) : route('admin.portfolio.store') }}" method="POST" style="max-width:760px">
        @csrf
        @if($editing) @method('PUT') @endif

        <div class="grid grid--2" style="gap:16px">
            <div class="field"><label>Name</label>
                <input type="text" name="name" value="{{ old('name', $company->name) }}" required></div>
            <div class="field"><label>Sector</label>
                <input type="text" name="sector" value="{{ old('sector', $company->sector) }}" required></div>
        </div>

        <div class="field"><label>Slug (optional)</label>
            <input type="text" name="slug" value="{{ old('slug', $company->slug) }}" placeholder="auto from name"></div>

        <div class="field"><label>Summary</label>
            <textarea name="summary" style="min-height:90px" required>{{ old('summary', $company->summary) }}</textarea></div>

        <div class="field"><label>Body (optional)</label>
            <textarea name="body" style="min-height:140px">{{ old('body', $company->body) }}</textarea></div>

        <div class="grid grid--2" style="gap:16px">
            <div class="field"><label>Website URL</label>
                <input type="text" name="site_url" value="{{ old('site_url', $company->site_url) }}"></div>
            <div class="field"><label>Sort order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $company->sort_order ?? 0) }}" min="0"></div>
        </div>

        <div class="field"><label>Capabilities delivered (comma or newline separated)</label>
            <textarea name="capabilities_delivered" style="min-height:80px">{{ old('capabilities_delivered', is_array($company->capabilities_delivered) ? implode(', ', $company->capabilities_delivered) : '') }}</textarea></div>

        <label style="display:flex;gap:8px;align-items:center;margin:8px 0 22px;color:var(--text-dim)">
            <input type="checkbox" name="is_published" value="1" style="width:auto" @checked(old('is_published', $company->is_published ?? true))> Published
        </label>

        <button type="submit" class="btn btn--primary">{{ $editing ? 'Save changes' : 'Create company' }}</button>
    </form>
@endsection
