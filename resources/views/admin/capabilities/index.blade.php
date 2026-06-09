@extends('admin.layout', ['title' => 'Capabilities'])

@section('content')
    <div class="admin__head">
        <h1 class="admin__title">Capabilities</h1>
        <a href="{{ route('admin.capabilities.create') }}" class="btn btn--primary">New capability</a>
    </div>

    <table class="admin-table">
        <thead><tr><th>Title</th><th>Icon</th><th>Order</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @forelse($capabilities as $c)
            <tr>
                <td>{{ $c->title }}</td>
                <td>{{ $c->icon }}</td>
                <td>{{ $c->sort_order }}</td>
                <td>@if($c->is_published)<span class="pill pill--on">live</span>@else<span class="pill">hidden</span>@endif</td>
                <td class="row-actions">
                    <a href="{{ route('admin.capabilities.edit', $c) }}">Edit</a>
                    <form action="{{ route('admin.capabilities.destroy', $c) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this capability?')">
                        @csrf @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="color:var(--text-faint)">No capabilities yet.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:24px">{{ $capabilities->links() }}</div>
@endsection
