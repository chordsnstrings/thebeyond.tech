<footer class="footer">
    <div class="container">
        <div class="footer__grid">
            <div>
                <a href="{{ route('home') }}" class="brand">
                    <span class="brand__mark" aria-hidden="true"></span>
                    <span>{{ config('site.name') }}</span>
                </a>
                <p class="footer__about">{{ config('site.description') }}</p>
                <form action="{{ route('subscribe') }}" method="POST" style="margin-top:22px;max-width:340px">
                    @csrf
                    <div class="field" style="margin-bottom:10px">
                        <label for="nl-email">Research updates</label>
                        <input id="nl-email" type="email" name="email" placeholder="you@firm.com" required>
                    </div>
                    <button type="submit" class="btn btn--ghost" style="width:100%;justify-content:center">Subscribe</button>
                    @if(session('newsletter'))
                        <p class="form-note" style="color:var(--accent)">{{ session('newsletter') }}</p>
                    @endif
                </form>
            </div>

            <div>
                <h4>Company</h4>
                <div class="footer__links">
                    <a href="{{ route('about') }}">About</a>
                    <a href="{{ route('capabilities') }}">Capabilities</a>
                    <a href="{{ route('portfolio') }}">Portfolio</a>
                    <a href="{{ route('research.index') }}">Research</a>
                    <a href="{{ route('glossary') }}">Glossary</a>
                </div>
            </div>

            <div>
                <h4>Connect</h4>
                <div class="footer__links">
                    <a href="{{ route('contact') }}">Contact</a>
                    <a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a>
                    @foreach(config('site.socials') as $label => $url)
                        <a href="{{ $url }}" rel="noopener" target="_blank">{{ $label }}</a>
                    @endforeach
                </div>
            </div>

            <div>
                <h4>Group</h4>
                <div class="footer__links">
                    <a href="{{ config('site.parent.url') }}" rel="noopener" target="_blank">ARKS Groups</a>
                    <span style="color:var(--text-faint);font-size:14px">{{ config('site.location') }}</span>
                </div>
            </div>
        </div>

        <div class="footer__bottom">
            <span>© {{ date('Y') }} {{ config('site.legal_name') }}. A subsidiary of ARKS Groups.</span>
            <span>Built beyond the brief.</span>
        </div>
    </div>
</footer>
