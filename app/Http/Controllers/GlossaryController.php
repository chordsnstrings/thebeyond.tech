<?php

namespace App\Http\Controllers;

use App\Support\Schema;
use App\Support\Seo;

class GlossaryController extends Controller
{
    public function index()
    {
        $terms = collect(config('glossary'))
            ->sortBy('term', SORT_NATURAL | SORT_FLAG_CASE)
            ->values();

        $definedTermSet = [
            '@context' => 'https://schema.org',
            '@type' => 'DefinedTermSet',
            'name' => 'Beyond Glossary — AI, Electric Mobility & Migration',
            'url' => url('/glossary'),
            'hasDefinedTerm' => $terms->map(fn ($t) => array_filter([
                '@type' => 'DefinedTerm',
                'name' => $t['term'],
                'description' => $t['definition'],
                'url' => isset($t['link']) ? url($t['link']) : null,
            ]))->all(),
        ];

        // Also expose as FAQ so answer engines treat each term as a Q&A pair.
        $faq = Schema::faq($terms->map(fn ($t) => [
            'q' => 'What is '.$t['term'].'?',
            'a' => $t['definition'],
        ])->all());

        $seo = Seo::make(
            title: 'Glossary: AI, Electric Mobility & Migration Terms',
            description: 'Plain-English definitions of key terms across applied AI, EV charging, '
                .'electric mobility, data and UAE migration — from the team at Beyond.',
            path: '/glossary',
            structuredData: [
                $definedTermSet,
                $faq,
                Schema::breadcrumb([
                    ['name' => 'Home', 'url' => url('/')],
                    ['name' => 'Glossary', 'url' => url('/glossary')],
                ]),
            ],
        );

        return view('pages.glossary', compact('seo', 'terms'));
    }
}
