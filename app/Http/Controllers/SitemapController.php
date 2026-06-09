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

        foreach (['/', '/about', '/capabilities', '/portfolio', '/research', '/contact'] as $path) {
            $urls[] = ['loc' => url($path), 'priority' => $path === '/' ? '1.0' : '0.8'];
        }

        foreach (ResearchArticle::published()->get() as $article) {
            $urls[] = [
                'loc' => url('/research/'.$article->slug),
                'lastmod' => $article->updated_at?->toAtomString(),
                'priority' => '0.7',
            ];
        }

        foreach (PortfolioCompany::published()->get() as $company) {
            $urls[] = [
                'loc' => url('/portfolio#'.$company->slug),
                'priority' => '0.6',
            ];
        }

        $xml = view('sitemap', compact('urls'))->render();

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
