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

- SEO-first: SSR, per-page meta/OG/Twitter, JSON-LD (`Organization`, `Article`), dynamic
  `/sitemap.xml`, `robots.txt`, canonical URLs
- Cursor-reactive type/grid hero (desktop) + touch-reactive hero (mobile)
- Separate desktop/mobile templates (`resources/views/desktop`, `resources/views/mobile`) chosen
  by `App\Http\Middleware\DetectDevice`. Add `?view=mobile` / `?view=desktop` to any URL to preview.
- DB-driven content: capabilities, portfolio companies, research articles
- Lightweight admin (`/admin`) to manage content and read contact submissions
- Contact form + newsletter capture (stored in MySQL, honeypot-protected)

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
