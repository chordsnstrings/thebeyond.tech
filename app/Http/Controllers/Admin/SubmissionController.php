<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;

class SubmissionController extends Controller
{
    public function index()
    {
        $submissions = ContactSubmission::latest()->paginate(20);

        return view('admin.submissions.index', compact('submissions'));
    }

    public function show(ContactSubmission $submission)
    {
        if (! $submission->is_read) {
            $submission->update(['is_read' => true]);
        }

        return view('admin.submissions.show', compact('submission'));
    }

    public function destroy(ContactSubmission $submission)
    {
        $submission->delete();

        return redirect()->route('admin.submissions.index')->with('status', 'Submission deleted.');
    }
}
