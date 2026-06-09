@extends('admin.layout', ['title' => 'Submissions'])

@section('content')
    <div class="admin__head">
        <h1 class="admin__title">Submissions</h1>
    </div>

    <table class="admin-table">
        <thead><tr><th>Name</th><th>Email</th><th>Type</th><th>When</th><th></th></tr></thead>
        <tbody>
        @forelse($submissions as $s)
            <tr>
                <td>{{ $s->name }} @unless($s->is_read)<span class="pill pill--on">new</span>@endunless</td>
                <td>{{ $s->email }}</td>
                <td>{{ ucfirst($s->inquiry_type) }}</td>
                <td>{{ $s->created_at->format('M j, Y') }}</td>
                <td class="row-actions"><a href="{{ route('admin.submissions.show', $s) }}">Open</a></td>
            </tr>
        @empty
            <tr><td colspan="5" style="color:var(--text-faint)">No submissions yet.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:24px">{{ $submissions->links() }}</div>
@endsection
