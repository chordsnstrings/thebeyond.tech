@extends('admin.layout', ['title' => 'Portfolio'])

@section('content')
    <div class="admin__head">
        <h1 class="admin__title">Portfolio</h1>
        <a href="{{ route('admin.portfolio.create') }}" class="btn btn--primary">New company</a>
    </div>

    <table class="admin-table">
        <thead><tr><th>Name</th><th>Sector</th><th>Order</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @forelse($companies as $c)
            <tr>
                <td>{{ $c->name }}</td>
                <td>{{ $c->sector }}</td>
                <td>{{ $c->sort_order }}</td>
                <td>@if($c->is_published)<span class="pill pill--on">live</span>@else<span class="pill">hidden</span>@endif</td>
                <td class="row-actions">
                    <a href="{{ route('admin.portfolio.edit', $c) }}">Edit</a>
                    <form action="{{ route('admin.portfolio.destroy', $c) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this company?')">
                        @csrf @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="color:var(--text-faint)">No companies yet.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:24px">{{ $companies->links() }}</div>
@endsection
