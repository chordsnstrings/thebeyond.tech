<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResearchArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ResearchController extends Controller
{
    public function index()
    {
        $articles = ResearchArticle::latest()->paginate(15);

        return view('admin.research.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.research.form', ['article' => new ResearchArticle()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        ResearchArticle::create($data);

        return redirect()->route('admin.research.index')->with('status', 'Article created.');
    }

    public function edit(ResearchArticle $article)
    {
        return view('admin.research.form', compact('article'));
    }

    public function update(Request $request, ResearchArticle $article)
    {
        $article->update($this->validated($request, $article));

        return redirect()->route('admin.research.index')->with('status', 'Article updated.');
    }

    public function destroy(ResearchArticle $article)
    {
        $article->delete();

        return redirect()->route('admin.research.index')->with('status', 'Article deleted.');
    }

    protected function validated(Request $request, ?ResearchArticle $article = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:200'],
            'category' => ['required', 'string', 'max:60'],
            'author' => ['required', 'string', 'max:120'],
            'excerpt' => ['required', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'cover_image' => ['nullable', 'string', 'max:500'],
            'meta_title' => ['nullable', 'string', 'max:200'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'keywords' => ['nullable', 'string', 'max:255'],
            'key_takeaways' => ['nullable', 'string'],
            'faqs' => ['nullable', 'string'],
            'read_minutes' => ['required', 'integer', 'min:1', 'max:60'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = Str::slug($data['slug'] ?: $data['title']);
        $data['is_published'] = $request->boolean('is_published');

        // One takeaway per line.
        $data['key_takeaways'] = collect(preg_split('/\r?\n/', (string) ($data['key_takeaways'] ?? '')))
            ->map(fn ($t) => trim($t))->filter()->values()->all();

        // FAQs: "Question :: Answer" per line.
        $data['faqs'] = collect(preg_split('/\r?\n/', (string) ($data['faqs'] ?? '')))
            ->map(fn ($line) => array_map('trim', explode('::', $line, 2)))
            ->filter(fn ($parts) => count($parts) === 2 && $parts[0] !== '' && $parts[1] !== '')
            ->map(fn ($parts) => ['q' => $parts[0], 'a' => $parts[1]])
            ->values()->all();

        return $data;
    }
}
