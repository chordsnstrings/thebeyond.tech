<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Capability;
use App\Models\ContactSubmission;
use App\Models\NewsletterSubscriber;
use App\Models\PortfolioCompany;
use App\Models\ResearchArticle;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'Research articles' => ResearchArticle::count(),
            'Portfolio companies' => PortfolioCompany::count(),
            'Capabilities' => Capability::count(),
            'Subscribers' => NewsletterSubscriber::count(),
        ];

        $submissions = ContactSubmission::latest()->take(8)->get();
        $unread = ContactSubmission::where('is_read', false)->count();

        return view('admin.dashboard', compact('stats', 'submissions', 'unread'));
    }
}
