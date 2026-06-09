<?php

namespace App\Support;

/**
 * Small value object that normalises per-page SEO metadata and exposes the
 * sitewide defaults. Controllers build one of these and hand it to the views;
 * partials/meta.blade.php renders the tags.
 */
class Seo
{
    public function __construct(
        public string $title,
        public string $description,
        public string $canonical,
        public ?string $image = null,
        public string $type = 'website',
        public array $structuredData = [],
    ) {
    }

    public static function make(
        ?string $title = null,
        ?string $description = null,
        ?string $path = null,
        ?string $image = null,
        string $type = 'website',
        array $structuredData = [],
    ): self {
        $brand = config('site.name');
        $full = $title ? "{$title} — {$brand}" : "{$brand} — ".config('site.tagline');

        return new self(
            title: $full,
            description: $description ?: config('site.description'),
            canonical: url($path ?? '/'),
            image: $image ? url($image) : url('/images/og-default.svg'),
            type: $type,
            structuredData: $structuredData,
        );
    }
}
