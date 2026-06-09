<section class="section" id="portfolio">
    <div class="container">
        <div class="section-head" data-reveal>
            <span class="eyebrow">Companies we power</span>
            <h2>The technology behind the ARKS portfolio.</h2>
            <p>Every company below runs on platforms, data systems and intelligent products
                designed and operated by Beyond.</p>
        </div>

        <div>
            @foreach($companies as $company)
                <article class="company" id="{{ $company->slug }}" data-reveal>
                    <div>
                        <div class="company__name">{{ $company->name }}</div>
                        <div class="company__sector">{{ $company->sector }}</div>
                    </div>
                    <div>
                        <p class="company__desc">{{ $company->summary }}</p>
                        @if($company->capabilities_delivered)
                            <div class="company__tags">
                                @foreach($company->capabilities_delivered as $tag)
                                    <span class="tag">{{ $tag }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    @if($company->site_url)
                        <a class="company__link" href="{{ $company->site_url }}" target="_blank" rel="noopener">Visit ↗</a>
                    @endif
                </article>
            @endforeach
        </div>
    </div>
</section>
