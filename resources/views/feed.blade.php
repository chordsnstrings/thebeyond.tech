<?php echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>{{ config('site.name') }} — Research &amp; Insights</title>
        <link>{{ url('/research') }}</link>
        <atom:link href="{{ url('/feed.xml') }}" rel="self" type="application/rss+xml"/>
        <description>{{ config('site.description') }}</description>
        <language>en</language>
        <lastBuildDate>{{ now()->toRssString() }}</lastBuildDate>
        @foreach($articles as $article)
        <item>
            <title>{{ $article->title }}</title>
            <link>{{ url('/research/'.$article->slug) }}</link>
            <guid isPermaLink="true">{{ url('/research/'.$article->slug) }}</guid>
            <category>{{ $article->category }}</category>
            <pubDate>{{ $article->published_at?->toRssString() }}</pubDate>
            <description>{{ $article->excerpt }}</description>
        </item>
        @endforeach
    </channel>
</rss>
