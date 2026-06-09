<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioCompany extends Model
{
    protected $fillable = [
        'name', 'slug', 'sector', 'summary', 'body', 'site_url',
        'capabilities_delivered', 'metrics', 'sort_order', 'is_published',
    ];

    protected $casts = [
        'capabilities_delivered' => 'array',
        'metrics' => 'array',
        'is_published' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order');
    }
}
