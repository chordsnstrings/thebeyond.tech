<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchArticle extends Model
{
    protected $fillable = [
        'title', 'slug', 'category', 'author', 'excerpt', 'body', 'cover_image',
        'meta_title', 'meta_description', 'keywords', 'key_takeaways', 'faqs',
        'read_minutes', 'published_at', 'is_published',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
        'key_takeaways' => 'array',
        'faqs' => 'array',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at');
    }

    /**
     * Distinct list of categories, safe for MySQL ONLY_FULL_GROUP_BY.
     *
     * reorder() drops any inherited ordering (e.g. the published() scope's
     * orderByDesc('published_at')): a SELECT DISTINCT ordered by a column that
     * is not in the SELECT list raises MySQL error 3065, even though SQLite
     * tolerates it. Keep the ORDER BY limited to the selected column.
     */
    public function scopeDistinctCategories($query)
    {
        return $query->select('category')->distinct()->reorder('category');
    }

    public function scopeSearch($query, ?string $term)
    {
        if (! $term) {
            return $query;
        }

        $like = '%'.$term.'%';

        return $query->where(function ($q) use ($like) {
            $q->where('title', 'like', $like)
                ->orWhere('excerpt', 'like', $like)
                ->orWhere('keywords', 'like', $like)
                ->orWhere('category', 'like', $like);
        });
    }

    public function getWordCountAttribute(): int
    {
        return max(1, str_word_count(strip_tags((string) $this->body)));
    }

    public function relatedArticles(int $limit = 3)
    {
        return static::published()
            ->where('id', '!=', $this->id)
            ->where('category', $this->category)
            ->take($limit)
            ->get();
    }

    public function getMetaTitleAttribute($value): string
    {
        return $value ?: $this->title;
    }

    public function getMetaDescriptionAttribute($value): string
    {
        return $value ?: $this->excerpt;
    }
}
