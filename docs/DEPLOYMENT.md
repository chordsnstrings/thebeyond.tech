# Developer Deployment Guide — SiteGround

A developer-oriented companion to **[DEPLOY.md](../DEPLOY.md)**. Where `DEPLOY.md` is the
step-by-step server runbook (first-time bootstrap), this guide explains the **mental model,
the local→production lifecycle, the rules you must not break, and how to debug a deploy** when
something goes wrong.

If you just need the commands to stand the site up on a fresh SiteGround account, read
`DEPLOY.md`. If you're about to ship a change and want to understand *how* it reaches
production, read this.

---

## 1. How this app deploys (the mental model)

- **It's a plain server-rendered Laravel app.** SiteGround runs it natively over **SSH +
  Composer + Git** — there is no container, no CI runner, no build server.
- **The server never runs Node/npm.** Front-end assets are built locally with Vite and the
  output (`public/build/`) is **committed to the repo**. The host just serves what's already
  there. This is the single most important thing to internalise (see §4).
- **`main` is the deploy branch.** Production tracks `main`; a deploy is essentially
  `git pull` on the server followed by Composer + cache rebuilds.
- **Content lives in MySQL, not in code.** Capabilities, portfolio companies, research
  articles and the glossary are database rows managed through `/admin`. Deploying code does
  **not** change content, and editing content does **not** require a deploy.

```
 your machine                              SiteGround server
 ┌─────────────────────────┐   git push    ┌──────────────────────────┐
 │ edit Blade / PHP / CSS   │  ───────────▶ │ git pull                 │
 │ npm run build  (Vite)    │   (to main)   │ composer install --no-dev│
 │ commit public/build/     │               │ php artisan migrate      │
 │ commit & push            │               │ php artisan optimize     │
 └─────────────────────────┘               └──────────────────────────┘
```

---

## 2. Architecture you must respect when deploying

| Concern | What it means for deployment |
| --- | --- |
| **Committed assets** | `public/build/` is generated, but **tracked in git**. Any CSS/JS change is invisible in production until you `npm run build` and commit the result. See §4. |
| **Device detection** | `App\Http\Middleware\DetectDevice` picks `resources/views/desktop/*` vs `resources/views/mobile/*` by User-Agent. One URL serves both — no separate mobile domain to deploy. Append `?view=mobile` / `?view=desktop` to force a template (works in prod too). |
| **DB-backed drivers** | `cache`, `session`, and `queue` default to the **database** (see `.env.example`). The migrations create the `cache`, `sessions`, and `jobs` tables — so `php artisan migrate` is mandatory, not optional. |
| **Mail is synchronous** | Contact/newsletter submissions are stored in MySQL; there are **no queued jobs**. You do **not** need a running queue worker. Email notifications (if you wire up SMTP) send in-request. |
| **Security headers + admin** | `SecurityHeaders` and `EnsureAdmin` middleware run in production. If you add a CDN or reverse proxy, make sure it doesn't strip headers or mangle `Host`. |

---

## 3. Local development setup

Requirements: **PHP 8.3+**, Composer, Node 18+ (for building assets only), and SQLite (dev) or
MySQL.

```bash
git clone <repo-url> thebeyond.tech
cd thebeyond.tech

composer install
cp .env.example .env
php artisan key:generate

# Dev uses SQLite — set in .env:
#   DB_CONNECTION=sqlite
#   (comment out DB_HOST/DB_PORT/DB_DATABASE/DB_USERNAME/DB_PASSWORD)
touch database/database.sqlite

php artisan migrate --seed     # builds schema + seeds 66 articles, 40 glossary terms, etc.

npm install
npm run dev                    # Vite dev server with HMR
php artisan serve              # http://127.0.0.1:8000
```

Preview the other template at any URL with `?view=mobile` or `?view=desktop`.

> `composer dev` runs the server, queue listener, log tailer (`pail`) and Vite together via
> `concurrently` — handy, but `php artisan serve` + `npm run dev` is enough.

---

## 4. The asset pipeline contract  ⚠️ read this

**The server does not build assets.** It serves the committed `public/build/` directory as-is.

So the workflow for any change to `resources/css/**` or `resources/js/**` is:

```bash
npm run build                  # regenerates public/build/ (hashed filenames + manifest.json)
git add public/build resources/
git commit -m "..."            # the built assets MUST be in the commit
git push
```

If you change front-end source but **forget to build and commit `public/build/`**, production
will keep serving the old CSS/JS — the classic "my style change didn't show up" deploy bug.
Conversely, Blade/PHP-only changes do **not** need a rebuild.

A fast self-check before pushing: `git status` should show changes under `public/build/`
whenever you touched `resources/css` or `resources/js`.

---

## 5. Release workflow

1. Branch off `main`, make the change, run `php artisan test`.
2. If front-end changed, `npm run build` and commit `public/build/` (see §4).
3. Open a PR into `main`, review, merge.
4. Deploy: on the server, pull `main` and run the update steps (§6). Production tracks `main`.

---

## 6. Deploying a change (update flow)

First-time server bootstrap (document root, SSL, DB creation) is in **[DEPLOY.md](../DEPLOY.md)**.
Once that's done, every subsequent release is:

```bash
cd ~/www/thebeyond.tech/app

php artisan down                                 # optional: maintenance mode
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force                      # applies any new migrations
php artisan optimize                             # config + route + view caches
php artisan up
```

- **PHP version**: set it in **Site Tools → Devs → PHP Manager** to **8.3+** (matches
  `composer.json`). Both the web SAPI and the CLI used over SSH must match.
- **Permissions**: `storage/` and `bootstrap/cache/` must be writable
  (`chmod -R ug+rw storage bootstrap/cache`).
- `php artisan optimize:clear` reverses all the caches if you need to debug.

---

## 7. Environment variables that matter in production

| Variable | Production value | Notes |
| --- | --- | --- |
| `APP_ENV` | `production` | |
| `APP_DEBUG` | `false` | Never `true` in prod — leaks stack traces. |
| `APP_KEY` | (generated) | `php artisan key:generate` once; **don't** rotate without invalidating sessions. |
| `APP_URL` | `https://www.thebeyond.tech` | Pick `www` *or* apex and redirect the other. Used for canonical URLs, sitemap, feed. |
| `DB_*` | MySQL creds | From Site Tools → Databases. |
| `ADMIN_EMAIL` / `ADMIN_PASSWORD` | strong values | **Change before the first `db:seed`** — these seed the admin account. |
| `MAIL_MAILER` | `smtp` (or `log`) | Configure SiteGround SMTP only if you want email notifications. |
| `SESSION_DRIVER` / `CACHE_STORE` / `QUEUE_CONNECTION` | `database` | Backed by tables created in migrations. |

---

## 8. Caching & the `config:cache` gotcha

`php artisan optimize` runs `config:cache`, `route:cache`, and `view:cache`. After
`config:cache`, **`env()` returns `null` everywhere except inside `config/*.php` files** —
Laravel reads the cached config, not `.env`. Practical consequences:

- Don't call `env()` outside `config/`. Read from `config('...')` instead.
- After editing `.env` on the server, you **must** re-run `php artisan config:cache` (or
  `optimize`) for the change to take effect.
- When debugging, `php artisan optimize:clear` removes the cached config so `.env` is read live.

---

## 9. Troubleshooting

| Symptom | Likely cause / fix |
| --- | --- |
| **HTTP 500, blank white page** | App can't write to `storage/` or `bootstrap/cache/`, or stale config cache. Check `storage/logs/laravel.log`; fix permissions; `php artisan optimize:clear`. |
| **CSS/JS change didn't ship** | `public/build/` wasn't rebuilt+committed (§4). Run `npm run build`, commit, redeploy. Also hard-refresh — filenames are content-hashed so browsers shouldn't cache stale, but CDNs might. |
| **`419 Page Expired` on forms** | Session table missing or not writable, or `APP_KEY` changed. Ensure migrations ran and `SESSION_DRIVER=database`. |
| **Wrong template (desktop on phone)** | Device detection is UA-based; some bots/proxies rewrite UA. Confirm with `?view=mobile`. If a CDN caches per-URL, vary on `User-Agent` or disable caching for HTML. |
| **`.env` edit had no effect** | Config is cached — re-run `php artisan config:cache` (§8). |
| **Composer errors on deploy** | Server PHP version ≠ 8.3+. Fix in PHP Manager; ensure the SSH CLI PHP matches the web PHP. |
| **404 on every route except `/`** | `mod_rewrite` / `public/.htaccess` not honoured, or document root not pointed at `public/`. See `DEPLOY.md` §4. |

---

## 10. Rollback

Because deploys are git pulls, rollback is a git operation:

```bash
cd ~/www/thebeyond.tech/app
git log --oneline -5                 # find the last good commit
git checkout <good-sha>              # or: git reset --hard <good-sha> on a deploy checkout
composer install --no-dev --optimize-autoloader
php artisan optimize
```

Then return to a branch tip when ready (`git checkout main`).

**Database caution:** code rollback does **not** undo a migration. If the bad release added a
migration, roll it back explicitly *before* (or as part of) reverting code:
`php artisan migrate:rollback --step=1`. Prefer backward-compatible migrations so code and
schema can roll independently. SiteGround keeps automatic DB backups (Site Tools → Security →
Backups) — take/restore one for destructive changes.

---

## 11. Pre-deploy checklist

- [ ] `php artisan test` passes locally.
- [ ] If front-end changed: `npm run build` ran and `public/build/` is committed (§4).
- [ ] `.env` on server: `APP_ENV=production`, `APP_DEBUG=false`, correct `APP_URL`.
- [ ] New migrations are backward-compatible and reviewed.
- [ ] Ran `php artisan migrate --force` and `php artisan optimize` after pulling.
- [ ] Smoke test: `/`, `/research`, a research article, `/sitemap.xml`, `/admin/login`, and one
      page with `?view=mobile`.

See the full launch-readiness list at the bottom of **[DEPLOY.md](../DEPLOY.md)**.
