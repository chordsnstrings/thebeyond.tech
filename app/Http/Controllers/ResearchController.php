<?php

namespace App\Http\Controllers;

use App\Models\ResearchArticle;
use App\Support\Seo;

class ResearchController extends Controller
{
    public function index()
    {
        $articles = ResearchArticle::published()->paginate(9);

        $seo = Seo::make(
            title: 'Research & Insights',
            description: 'Applied research and perspectives on AI, data and engineering '
                .'from the team building the ARKS technology stack.',
            path: '/research',
        );

        return view('pages.research-index', compact('seo', 'articles'));
    }

    public function show(ResearchArticle $article)
    {
        abort_unless($article->is_published && $article->published_at?->isPast(), 404);

        $seo = Seo::make(
            title: $article->meta_title,
            description: $article->meta_description,
            path: '/research/'.$article->slug,
            image: $article->cover_image,
            type: 'article',
            structuredData: [$this->articleSchema($article)],
        );

        return view('pages.research-show', compact('seo', 'article'));
    }

    protected function articleSchema(ResearchArticle $article): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $article->title,
            'description' => $article->excerpt,
            'author' => [
                '@type' => 'Organization',
                'name' => $article->author,
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('site.legal_name'),
            ],
            'datePublished' => $article->published_at?->toIso8601String(),
            'dateModified' => $article->updated_at?->toIso8601String(),
            'mainEntityOfPage' => url('/research/'.$article->slug),
        ];
    }
}
