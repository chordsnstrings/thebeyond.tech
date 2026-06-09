<?php

namespace App\Http\Controllers;

use App\Models\Capability;
use App\Models\PortfolioCompany;
use App\Models\ResearchArticle;
use App\Support\Schema;
use App\Support\Seo;

class PageController extends Controller
{
    public function home()
    {
        $capabilities = Capability::published()->get();
        $companies = PortfolioCompany::published()->get();
        $articles = ResearchArticle::published()->take(3)->get();

        $seo = Seo::make(structuredData: [
            Schema::organization(),
            Schema::website(),
        ]);

        return view('pages.home', compact('seo', 'capabilities', 'companies', 'articles'));
    }

    public function about()
    {
        $seo = Seo::make(
            title: 'About',
            description: 'Beyond is the technology, AI and research engine of ARKS Groups — '
                .'a multi-sector holding group based in Dubai, UAE.',
            path: '/about',
            structuredData: [$this->pageGraph('About Beyond', '/about',
                'Beyond is the technology, AI and research engine of ARKS Groups.')],
        );

        return view('pages.about', compact('seo'));
    }

    public function capabilities()
    {
        $capabilities = Capability::published()->get();

        $seo = Seo::make(
            title: 'Capabilities',
            description: 'Applied AI, research, product engineering and data platforms — '
                .'the disciplines Beyond uses to power the ARKS portfolio.',
            path: '/capabilities',
            structuredData: [$this->pageGraph('Capabilities', '/capabilities',
                'Applied AI, research, product engineering and data platforms.')],
        );

        return view('pages.capabilities', compact('seo', 'capabilities'));
    }

    public function portfolio()
    {
        $companies = PortfolioCompany::published()->get();

        $seo = Seo::make(
            title: 'Portfolio',
            description: 'The companies Beyond powers across mobility, EV charging, migration and wellness.',
            path: '/portfolio',
            structuredData: [$this->pageGraph('Portfolio', '/portfolio',
                'The companies Beyond powers across mobility, EV charging, migration and wellness.')],
        );

        return view('pages.portfolio', compact('seo', 'companies'));
    }

    /**
     * BreadcrumbList graph for a simple interior page.
     */
    protected function pageGraph(string $name, string $path, string $description): array
    {
        return Schema::breadcrumb([
            ['name' => 'Home', 'url' => url('/')],
            ['name' => $name, 'url' => url($path)],
        ]);
    }
}
