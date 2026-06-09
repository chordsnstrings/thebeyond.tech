# thebeyond.tech

Marketing & content site for **Beyond** — the technology, AI & research engine of
[ARKS Groups](https://www.arks.ae). Built with **Laravel + MySQL**, server-rendered for SEO,
with a dark, sophisticated UI, a cursor-reactive hero, and **separate mobile templates** served
via server-side device detection. Designed to deploy natively to **SiteGround**.

## Stack

- **Laravel 13** (PHP 8.2+), Blade, Eloquent
- **MySQL** in production (SQLite for local dev/tests)
- **Vite** for asset bundling — assets are pre-built and committed (`public/build`) so the host
  needs no Node step
- Custom CSS design system (`resources/css/app.css`) + vanilla JS (`resources/js/`)

## Features

- Cursor-reactive type/grid hero (desktop) + touch-reactive hero (mobile)
- Separate desktop/mobile templates (`resources/views/desktop`, `resources/views/mobile`) chosen
  by `App\Http\Middleware\DetectDevice`. Add `?view=mobile` / `?view=desktop` to any URL to preview.
- DB-driven content: capabilities, portfolio companies, research articles
- Research library with full-text-ish search (`?q=`) and category filtering
- Lightweight admin (`/admin`) to manage content (incl. SEO keywords, key takeaways, FAQs) and
  read contact submissions
- Contact form + newsletter capture (stored in MySQL, honeypot-protected)

## SEO & LLM / answer-engine optimization

Built to be found by both classic search and AI answer engines (GEO/AEO):

- **Server-rendered** HTML, per-page `<title>`/meta/canonical, Open Graph + Twitter cards, default
  branded share image (`public/images/og-default.svg`)
- **Structured data (JSON-LD)** via `App\Support\Schema`: `Organization` (+ `parentOrganization`
  → ARKS), `WebSite` with `SearchAction`, `BreadcrumbList`, `Article` (wordCount, keywords,
  author, publisher), `FAQPage`, `CollectionPage`
- **Article rich content**: key-takeaways box + FAQ accordion (both mirrored into schema for
  featured snippets and clean LLM extraction)
- **Discoverability endpoints**: dynamic `/sitemap.xml` (with `lastmod`/`changefreq`),
  `/feed.xml` (RSS), and **`/llms.txt`** (curated Markdown site map for LLM crawlers)
- **`robots.txt`** explicitly welcomes major AI crawlers (GPTBot, ClaudeBot, PerplexityBot,
  Google-Extended, etc.) and points to the sitemap
- **Single URL per page** for desktop + mobile (no duplicate-content split), internal linking
  across the research cluster, and topical authorship (per-desk authors) for E-E-A-T

### Content library

The seeders ship a **34-article**, topic-clustered research library targeting winnable, high-intent
demand (UAE/Dubai long-tail + applied-AI thought leadership), plus a **glossary** and **category
hub pages**:

- **Electric mobility / EV** — charging in Dubai, costs, buying an EV, home wallbox, CPOs, charging
  times, EV vs petrol, fleet AI, electric chauffeur
- **Migration** — UAE Golden Visa (overview + property route), freelance visa, moving to Dubai,
  cost of living, Dubai vs Abu Dhabi, family sponsorship, AI in immigration
- **Applied AI** — applied AI, AI agents, LLMs in production, RAG, vector databases, prompt
  engineering, AI customer support, document AI, predictive maintenance
- **AI & search** — Generative Engine Optimization (GEO), Answer Engine Optimization (AEO)
- **Data & growth** — D2C personalization, retention analytics, AI in wellness, shared data
  platforms, the modern data stack

Additional discoverability surfaces:

- **`/glossary`** — 24 plain-English definitions with `DefinedTermSet` + `DefinedTerm` + `FAQPage`
  schema (a concentrated long-tail + LLM-extraction asset)
- **Category hub pages** (`/research?category=…`) with unique intro copy per topic (`config/research_topics.php`)

Add or edit content via the admin, or extend `database/seeders/ResearchArticleSeeder.php`,
`ResearchArticleSeederTwo.php`, `config/glossary.php` and `config/research_topics.php`.

## Local development

```bash
composer install
npm install
cp .env.example .env        # then set APP_KEY via the next command
php artisan key:generate

# Local uses SQLite by default; create the file:
touch database/database.sqlite
php artisan migrate:fresh --seed

npm run build               # or: npm run dev
php artisan serve
```

Visit `http://127.0.0.1:8000`. Admin at `/admin` — seeded credentials come from
`ADMIN_EMAIL` / `ADMIN_PASSWORD` (defaults: `admin@thebeyond.tech` / `change-me-now`).
**Change these before going live.**

## Tests

```bash
php artisan test
```

## Content model

| Table                 | Purpose                                         | Managed in admin |
|-----------------------|-------------------------------------------------|------------------|
| `capabilities`        | The four capability pillars (AI, Research, …)   | Yes              |
| `portfolio_companies` | ARKS companies Beyond powers                    | Yes              |
| `research_articles`   | Research / insights posts                       | Yes              |
| `contact_submissions` | Inbound contact form messages                   | Read / delete    |
| `newsletter_subscribers` | Newsletter sign-ups                          | —                |

## Deployment

See **[DEPLOY.md](DEPLOY.md)** for the SiteGround walkthrough.
