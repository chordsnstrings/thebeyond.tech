<section class="section" id="capabilities">
    <div class="container">
        <div class="section-head" data-reveal>
            <span class="eyebrow">Capabilities</span>
            <h2>One engine. Four disciplines.</h2>
            <p>Beyond brings frontier AI, research, engineering and data under one roof — then deploys
                them into real operations across the group.</p>
        </div>

        <div class="grid grid--4">
            @foreach($capabilities as $cap)
                <article class="card" data-reveal style="transition-delay: {{ $loop->index * 60 }}ms">
                    <div class="card__icon">@include('partials.icon', ['name' => $cap->icon])</div>
                    <h3>{{ $cap->title }}</h3>
                    <p>{{ $cap->summary }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
