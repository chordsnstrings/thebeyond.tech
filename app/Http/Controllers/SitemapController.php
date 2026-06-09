<?php

namespace App\Http\Controllers;

use App\Models\PortfolioCompany;
use App\Models\ResearchArticle;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [];

        $statics = [
            '/' => '1.0',
            '/about' => '0.7',
            '/capabilities' => '0.8',
            '/portfolio' => '0.8',
            '/research' => '0.9',
            '/contact' => '0.6',
        ];
        foreach ($statics as $path => $priority) {
            $urls[] = [
                'loc' => url($path),
                'priority' => $priority,
                'changefreq' => $path === '/research' ? 'daily' : 'weekly',
            ];
        }

        foreach (ResearchArticle::published()->get() as $article) {
            $urls[] = [
                'loc' => url('/research/'.$article->slug),
                'lastmod' => $article->updated_at?->toAtomString(),
                'priority' => '0.7',
                'changefreq' => 'monthly',
            ];
        }

        foreach (PortfolioCompany::published()->get() as $company) {
            $urls[] = [
                'loc' => url('/portfolio#'.$company->slug),
                'priority' => '0.5',
                'changefreq' => 'monthly',
            ];
        }

        $xml = view('sitemap', compact('urls'))->render();

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=utf-8']);
    }
}
