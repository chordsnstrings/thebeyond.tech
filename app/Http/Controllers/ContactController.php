<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use App\Models\NewsletterSubscriber;
use App\Support\Seo;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        $seo = Seo::make(
            title: 'Contact',
            description: 'Partner with Beyond. We work with select VCs, family offices and '
                .'operators building category-defining companies.',
            path: '/contact',
        );

        return view('pages.contact', compact('seo'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'organization' => ['nullable', 'string', 'max:160'],
            'inquiry_type' => ['required', 'in:investor,partnership,talent,general'],
            'message' => ['required', 'string', 'max:4000'],
            // Honeypot — must stay empty.
            'company_website' => ['nullable', 'size:0'],
        ]);

        ContactSubmission::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'organization' => $data['organization'] ?? null,
            'inquiry_type' => $data['inquiry_type'],
            'message' => $data['message'],
            'ip_address' => $request->ip(),
        ]);

        return back()->with('status', 'Thank you — your message has reached the team. We respond within two business days.');
    }

    public function subscribe(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:160'],
        ]);

        NewsletterSubscriber::firstOrCreate(['email' => $data['email']]);

        return back()->with('newsletter', 'You are subscribed to Beyond research updates.');
    }
}
