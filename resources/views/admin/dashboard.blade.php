@extends('admin.layout', ['title' => 'Dashboard'])

@section('content')
    <div class="admin__head">
        <h1 class="admin__title">Dashboard</h1>
    </div>

    <div class="admin-grid">
        @foreach($stats as $label => $value)
            <div class="stat">
                <b>{{ $value }}</b>
                <span>{{ $label }}</span>
            </div>
        @endforeach
    </div>

    <div class="admin__head" style="margin-top:40px">
        <h2 class="admin__title" style="font-size:20px">Recent submissions @if($unread)<span class="pill pill--on">{{ $unread }} new</span>@endif</h2>
        <a href="{{ route('admin.submissions.index') }}" class="btn btn--ghost">View all</a>
    </div>

    <table class="admin-table">
        <thead><tr><th>Name</th><th>Type</th><th>Organization</th><th>When</th><th></th></tr></thead>
        <tbody>
        @forelse($submissions as $s)
            <tr>
                <td>{{ $s->name }} @unless($s->is_read)<span class="pill pill--on">new</span>@endunless</td>
                <td>{{ ucfirst($s->inquiry_type) }}</td>
                <td>{{ $s->organization ?: '—' }}</td>
                <td>{{ $s->created_at->diffForHumans() }}</td>
                <td class="row-actions"><a href="{{ route('admin.submissions.show', $s) }}">Open</a></td>
            </tr>
        @empty
            <tr><td colspan="5" style="color:var(--text-faint)">No submissions yet.</td></tr>
        @endforelse
        </tbody>
    </table>
@endsection
