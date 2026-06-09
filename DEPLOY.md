# Deploying to SiteGround

This is a standard Laravel app. SiteGround runs it natively over SSH + Composer. Assets are
pre-built and committed (`public/build`), so **no Node/npm is required on the server**.

## 1. Create the database

In **Site Tools → Databases → MySQL**:

1. Create a database (e.g. `beyond_prod`).
2. Create a user and grant it access to that database.
3. Note the database name, user, and password.

## 2. Get the code onto the server

SiteGround document roots live under `~/www/<domain>/public_html`. The cleanest layout is to
place the Laravel app **next to** `public_html` and point the domain at the app's `public/`.

Via SSH (Site Tools → Devs → SSH):

```bash
cd ~/www/thebeyond.tech
git clone <your-repo-url> app
cd app
composer install --no-dev --optimize-autoloader
```

> If you cannot change the document root (see step 4 option B), you can instead deploy the repo
> so that the contents of `public/` map onto `public_html/` — see option B below.

## 3. Configure the environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://www.thebeyond.tech

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=beyond_prod
DB_USERNAME=your_user
DB_PASSWORD=your_password

# IMPORTANT: change these before the first seed
ADMIN_EMAIL=you@thebeyond.tech
ADMIN_PASSWORD=a-strong-password

MAIL_MAILER=smtp        # configure SiteGround SMTP if you want email notifications
```

Then build the database and caches:

```bash
php artisan migrate --force --seed
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Set writable permissions:

```bash
chmod -R ug+rw storage bootstrap/cache
```

## 4. Point the domain at `public/`

**Option A — change the document root (preferred).**
In **Site Tools → Domain → Document Root**, set the domain's root to:

```
~/www/thebeyond.tech/app/public
```

**Option B — symlink into `public_html`.**
If you keep the default document root, replace `public_html` with the app's `public`:

```bash
cd ~/www/thebeyond.tech
rm -rf public_html
ln -s app/public public_html
```

If symlinks are restricted, copy `public/`'s contents into `public_html/` and edit
`public_html/index.php` so the two `require`/`bootstrap` paths point at `../app/...`.

## 5. HTTPS, caching & scheduler

- Enable **Let's Encrypt SSL** in Site Tools, then force HTTPS.
- Enable SiteGround's dynamic caching; Laravel already sends sensible headers.
- (Optional) If you add scheduled tasks, add a cron job in Site Tools:
  `php ~/www/thebeyond.tech/app/artisan schedule:run` every minute.

## 6. Updating after the first deploy

```bash
cd ~/www/thebeyond.tech/app
git pull
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

Because `public/build` is committed, pulling new code ships the latest CSS/JS automatically.
If you change front-end source locally, run `npm run build` and commit the result before pulling
on the server.

## Verify

- `https://www.thebeyond.tech/` loads with the hero animation.
- `https://www.thebeyond.tech/sitemap.xml` returns XML.
- `https://www.thebeyond.tech/admin/login` — sign in, confirm content management works.
- Load the site on a phone and confirm the mobile templates render (or use `?view=mobile`).
