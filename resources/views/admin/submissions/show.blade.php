@extends('admin.layout', ['title' => 'Submission'])

@section('content')
    <div class="admin__head">
        <h1 class="admin__title">{{ $submission->name }}</h1>
        <a href="{{ route('admin.submissions.index') }}" class="btn btn--ghost">Back</a>
    </div>

    <div class="card" style="max-width:680px">
        <dl style="display:grid;grid-template-columns:140px 1fr;gap:14px 18px;font-size:15px">
            <dt style="color:var(--text-faint)">Email</dt>
            <dd><a href="mailto:{{ $submission->email }}" style="color:var(--accent)">{{ $submission->email }}</a></dd>

            <dt style="color:var(--text-faint)">Organization</dt>
            <dd>{{ $submission->organization ?: '—' }}</dd>

            <dt style="color:var(--text-faint)">Type</dt>
            <dd>{{ ucfirst($submission->inquiry_type) }}</dd>

            <dt style="color:var(--text-faint)">Received</dt>
            <dd>{{ $submission->created_at->format('F j, Y g:i a') }}</dd>

            <dt style="color:var(--text-faint)">Message</dt>
            <dd style="white-space:pre-wrap;line-height:1.6">{{ $submission->message }}</dd>
        </dl>

        <form action="{{ route('admin.submissions.destroy', $submission) }}" method="POST" style="margin-top:24px" onsubmit="return confirm('Delete this submission?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn--ghost">Delete</button>
        </form>
    </div>
@endsection
