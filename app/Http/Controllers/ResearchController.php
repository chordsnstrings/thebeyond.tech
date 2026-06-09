<?php

namespace App\Http\Controllers;

use App\Models\ResearchArticle;
use App\Support\Schema;
use App\Support\Seo;
use Illuminate\Http\Request;

class ResearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->query('q', ''));
        $category = trim((string) $request->query('category', ''));

        $articles = ResearchArticle::published()
            ->when($query, fn ($q) => $q->search($query))
            ->when($category, fn ($q) => $q->where('category', $category))
            ->paginate(9)
            ->withQueryString();

        $categories = ResearchArticle::published()
            ->select('category')->distinct()->orderBy('category')->pluck('category');

        $title = 'Research & Insights';
        $topicIntro = null;
        if ($category) {
            $title = $category.' — Research';
            $topicIntro = config('research_topics.'.$category);
        }

        $seo = Seo::make(
            title: $title,
            description: 'Applied research and practical guides on AI, electric mobility, EV charging, '
                .'relocation technology and data from the team building the ARKS technology stack.',
            path: '/research',
            structuredData: [
                Schema::breadcrumb([
                    ['name' => 'Home', 'url' => url('/')],
                    ['name' => 'Research', 'url' => url('/research')],
                ]),
                Schema::collectionPage($title, url('/research'), $articles->getCollection()),
            ],
        );

        return view('pages.research-index', compact('seo', 'articles', 'categories', 'query', 'category', 'topicIntro'));
    }

    public function show(ResearchArticle $article)
    {
        abort_unless($article->is_published && $article->published_at?->isPast(), 404);

        $related = $article->relatedArticles();

        $structured = [
            Schema::article($article),
            Schema::breadcrumb([
                ['name' => 'Home', 'url' => url('/')],
                ['name' => 'Research', 'url' => url('/research')],
                ['name' => $article->title, 'url' => url('/research/'.$article->slug)],
            ]),
        ];

        if (! empty($article->faqs)) {
            $structured[] = Schema::faq($article->faqs);
        }

        $seo = Seo::make(
            title: $article->meta_title,
            description: $article->meta_description,
            path: '/research/'.$article->slug,
            image: $article->cover_image,
            type: 'article',
            structuredData: $structured,
        );

        return view('pages.research-show', compact('seo', 'article', 'related'));
    }
}
