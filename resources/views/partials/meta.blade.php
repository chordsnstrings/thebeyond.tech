@php($seo = $seo ?? \App\Support\Seo::make())
<title>{{ $seo->title }}</title>
<meta name="description" content="{{ $seo->description }}">
<link rel="canonical" href="{{ $seo->canonical }}">
<meta name="robots" content="index, follow, max-image-preview:large">

{{-- Open Graph --}}
<meta property="og:type" content="{{ $seo->type }}">
<meta property="og:site_name" content="{{ config('site.name') }}">
<meta property="og:title" content="{{ $seo->title }}">
<meta property="og:description" content="{{ $seo->description }}">
<meta property="og:url" content="{{ $seo->canonical }}">
@if($seo->image)
<meta property="og:image" content="{{ $seo->image }}">
@endif

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seo->title }}">
<meta name="twitter:description" content="{{ $seo->description }}">
@if($seo->image)
<meta name="twitter:image" content="{{ $seo->image }}">
@endif

{{-- Structured data --}}
@foreach($seo->structuredData as $schema)
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endforeach
