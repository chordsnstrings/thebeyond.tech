<?php

namespace App\Support;

use App\Models\ResearchArticle;
use Illuminate\Support\Collection;

/**
 * Builders for schema.org JSON-LD graphs. Rich, valid structured data is the
 * single biggest lever for both classic rich results and LLM answer engines,
 * which lean heavily on explicit machine-readable facts.
 */
class Schema
{
    public static function organization(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            '@id' => url('/#organization'),
            'name' => config('site.legal_name'),
            'alternateName' => config('site.name'),
            'url' => config('site.url'),
            'logo' => url('/images/og-default.svg'),
            'description' => config('site.description'),
            'foundingLocation' => 'Dubai, United Arab Emirates',
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

    public static function website(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => url('/#website'),
            'name' => config('site.name'),
            'url' => config('site.url'),
            'description' => config('site.description'),
            'publisher' => ['@id' => url('/#organization')],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => url('/research').'?q={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
            'inLanguage' => 'en',
        ];
    }

    public static function breadcrumb(array $items): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($items)->values()->map(fn ($item, $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $item['name'],
                'item' => $item['url'],
            ])->all(),
        ];
    }

    public static function article(ResearchArticle $article): array
    {
        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $article->title,
            'description' => $article->excerpt,
            'image' => $article->cover_image ? [url($article->cover_image)] : [url('/images/og-default.svg')],
            'wordCount' => $article->word_count,
            'keywords' => $article->keywords,
            'articleSection' => $article->category,
            'inLanguage' => 'en',
            'author' => [
                '@type' => 'Organization',
                'name' => $article->author,
                'url' => config('site.url'),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('site.legal_name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => url('/images/og-default.svg'),
                ],
            ],
            'datePublished' => $article->published_at?->toIso8601String(),
            'dateModified' => $article->updated_at?->toIso8601String(),
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => url('/research/'.$article->slug),
            ],
        ]);
    }

    public static function faq(array $faqs): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => collect($faqs)->map(fn ($faq) => [
                '@type' => 'Question',
                'name' => $faq['q'] ?? '',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['a'] ?? '',
                ],
            ])->all(),
        ];
    }

    public static function collectionPage(string $name, string $url, Collection $articles): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => $name,
            'url' => $url,
            'isPartOf' => ['@id' => url('/#website')],
            'mainEntity' => [
                '@type' => 'ItemList',
                'itemListElement' => $articles->values()->map(fn ($a, $i) => [
                    '@type' => 'ListItem',
                    'position' => $i + 1,
                    'url' => url('/research/'.$a->slug),
                    'name' => $a->title,
                ])->all(),
            ],
        ];
    }

    public static function webPage(string $name, string $url, string $description, array $breadcrumb = []): array
    {
        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => $name,
            'url' => $url,
            'description' => $description,
            'isPartOf' => ['@id' => url('/#website')],
            'breadcrumb' => $breadcrumb ? ['@id' => $url.'#breadcrumb'] : null,
        ]);
    }
}
