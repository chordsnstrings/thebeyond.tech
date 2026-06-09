<?php

namespace App\Http\Controllers;

use App\Models\Capability;
use App\Models\PortfolioCompany;
use App\Models\ResearchArticle;
use Illuminate\Http\Response;

class DiscoveryController extends Controller
{
    /**
     * llms.txt — an emerging convention that gives LLM crawlers a clean,
     * curated map of the site in Markdown. https://llmstxt.org
     */
    public function llms(): Response
    {
        $name = config('site.name');
        $articles = ResearchArticle::published()->get();
        $companies = PortfolioCompany::published()->get();
        $capabilities = Capability::published()->get();

        $lines = [];
        $lines[] = "# {$name} — ".config('site.legal_name');
        $lines[] = '';
        $lines[] = '> '.config('site.description');
        $lines[] = '';
        $lines[] = config('site.name').' is the in-house technology, AI and research studio of '
            .config('site.parent.name').' ('.config('site.parent.url').'), headquartered in '
            .config('site.location').'. It designs, builds and operates the platforms, data systems '
            .'and intelligent products that run the ARKS portfolio across electric mobility, EV '
            .'charging, migration and wellness.';
        $lines[] = '';

        $lines[] = '## Core pages';
        foreach ([
            'Home' => '/',
            'About' => '/about',
            'Capabilities' => '/capabilities',
            'Portfolio' => '/portfolio',
            'Research' => '/research',
            'Contact' => '/contact',
        ] as $label => $path) {
            $lines[] = "- [{$label}](".url($path).')';
        }
        $lines[] = '';

        $lines[] = '## Capabilities';
        foreach ($capabilities as $cap) {
            $lines[] = "- **{$cap->title}**: {$cap->summary}";
        }
        $lines[] = '';

        $lines[] = '## Portfolio (companies powered by '.$name.')';
        foreach ($companies as $company) {
            $lines[] = "- **{$company->name}** ({$company->sector}): {$company->summary}";
        }
        $lines[] = '';

        $lines[] = '## Research & guides';
        foreach ($articles as $article) {
            $lines[] = '- ['.$article->title.']('.url('/research/'.$article->slug).'): '.$article->excerpt;
        }
        $lines[] = '';

        $lines[] = '## Contact';
        $lines[] = '- Email: '.config('site.email');
        $lines[] = '- Location: '.config('site.location');
        $lines[] = '';

        return response(implode("\n", $lines), 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
        ]);
    }

    /**
     * RSS 2.0 feed for the research library — aids discovery and gives crawlers
     * (including LLM ingestion pipelines) a structured content stream.
     */
    public function feed(): Response
    {
        $articles = ResearchArticle::published()->take(30)->get();

        $xml = view('feed', compact('articles'))->render();

        return response($xml, 200, ['Content-Type' => 'application/rss+xml; charset=utf-8']);
    }
}
