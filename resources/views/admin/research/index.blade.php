@extends('admin.layout', ['title' => 'Research'])

@section('content')
    <div class="admin__head">
        <h1 class="admin__title">Research</h1>
        <a href="{{ route('admin.research.create') }}" class="btn btn--primary">New article</a>
    </div>

    <table class="admin-table">
        <thead><tr><th>Title</th><th>Category</th><th>Status</th><th>Published</th><th></th></tr></thead>
        <tbody>
        @forelse($articles as $a)
            <tr>
                <td>{{ $a->title }}</td>
                <td>{{ $a->category }}</td>
                <td>@if($a->is_published)<span class="pill pill--on">live</span>@else<span class="pill">draft</span>@endif</td>
                <td>{{ $a->published_at?->format('M j, Y') ?? '—' }}</td>
                <td class="row-actions">
                    <a href="{{ route('admin.research.edit', $a) }}">Edit</a>
                    <form action="{{ route('admin.research.destroy', $a) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this article?')">
                        @csrf @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="color:var(--text-faint)">No articles yet.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:24px">{{ $articles->links() }}</div>
@endsection
