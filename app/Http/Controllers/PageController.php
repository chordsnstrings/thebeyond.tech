<?php

namespace App\Http\Controllers;

use App\Models\Capability;
use App\Models\PortfolioCompany;
use App\Models\ResearchArticle;
use App\Support\Seo;

class PageController extends Controller
{
    public function home()
    {
        $capabilities = Capability::published()->get();
        $companies = PortfolioCompany::published()->get();
        $articles = ResearchArticle::published()->take(3)->get();

        $seo = Seo::make(structuredData: [$this->organizationSchema()]);

        return view('pages.home', compact('seo', 'capabilities', 'companies', 'articles'));
    }

    public function about()
    {
        $seo = Seo::make(
            title: 'About',
            description: 'Beyond is the technology, AI and research engine of ARKS Groups — '
                .'a multi-sector holding group based in Dubai.',
            path: '/about',
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
        );

        return view('pages.capabilities', compact('seo', 'capabilities'));
    }

    public function portfolio()
    {
        $companies = PortfolioCompany::published()->get();

        $seo = Seo::make(
            title: 'Portfolio',
            description: 'The companies Beyond powers across mobility, energy, migration and wellness.',
            path: '/portfolio',
        );

        return view('pages.portfolio', compact('seo', 'companies'));
    }

    protected function organizationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => config('site.legal_name'),
            'alternateName' => config('site.name'),
            'url' => config('site.url'),
            'description' => config('site.description'),
            'parentOrganization' => [
                '@type' => 'Organization',
                'name' => config('site.parent.name'),
                'url' => config('site.parent.url'),
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Dubai',
                'addressCountry' => 'AE',
            ],
            'sameAs' => array_values(config('site.socials')),
        ];
    }
}
