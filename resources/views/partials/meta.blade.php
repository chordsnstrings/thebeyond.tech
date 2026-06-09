@php($seo = $seo ?? \App\Support\Seo::make())
<title>{{ $seo->title }}</title>
<meta name="description" content="{{ $seo->description }}">
<link rel="canonical" href="{{ $seo->canonical }}">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<meta name="author" content="{{ config('site.legal_name') }}">
<meta name="publisher" content="{{ config('site.legal_name') }}">
<link rel="alternate" type="application/rss+xml" title="{{ config('site.name') }} Research" href="{{ url('/feed.xml') }}">

{{-- Open Graph --}}
<meta property="og:type" content="{{ $seo->type }}">
<meta property="og:site_name" content="{{ config('site.name') }}">
<meta property="og:title" content="{{ $seo->title }}">
<meta property="og:description" content="{{ $seo->description }}">
<meta property="og:url" content="{{ $seo->canonical }}">
<meta property="og:locale" content="en_US">
<meta property="og:image" content="{{ $seo->image }}">
<meta property="og:image:alt" content="{{ config('site.name') }} — {{ config('site.tagline') }}">

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seo->title }}">
<meta name="twitter:description" content="{{ $seo->description }}">
<meta name="twitter:image" content="{{ $seo->image }}">

{{-- Structured data --}}
@foreach($seo->structuredData as $schema)
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endforeach

@stack('meta')
