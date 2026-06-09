<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchArticle extends Model
{
    protected $fillable = [
        'title', 'slug', 'category', 'author', 'excerpt', 'body', 'cover_image',
        'meta_title', 'meta_description', 'read_minutes', 'published_at', 'is_published',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
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

    public function getMetaTitleAttribute($value): string
    {
        return $value ?: $this->title;
    }

    public function getMetaDescriptionAttribute($value): string
    {
        return $value ?: $this->excerpt;
    }
}
