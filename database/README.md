# Database files

Same idea as **Stay Eazi** (`stayeazi_eaziapp_db.sql` + `manual_mysql_patches.sql`): **Laravel migrations are canonical**; SQL supports review, backup, and hosts **without** Artisan.

| Item | Purpose |
|------|--------|
| **`migrations/`** | **Canonical** schema — run `php artisan migrate` on each environment (after backup). Only `*.php` files belong here. |
| **`myauto_torque_db.sql`** | **Single MySQL import** — `CREATE TABLE` for the full app schema **plus** baseline `INSERT`s (Spatie `roles`, `site_settings`, `cms_pages` for home/about/faq/contact). Regenerate the baseline block from `database/seed-data/*.html` with `php artisan db:generate-mysql-baseline-data` (rewrites only the section after `-- MYAUTO_TORQUE_BASELINE_DATA_START`). Does **not** include user accounts or vehicle listings (those come from the running app / Laravel). |
| **`manual_mysql_patches.sql`** | **Fallback only** — hosts that **cannot** run Artisan (one-off `ALTER TABLE`, indexes, charset fixes). Prefer `php artisan migrate` everywhere you can. |

Prefer adding schema **only** via **`migrations/`**. Edit the structure portion of `myauto_torque_db.sql` when you need a portable dump that matches migrations.

---

## Production / staging workflow

1. After backup:

   ```bash
   php artisan migrate:status
   php artisan migrate --force
   ```

2. Seed baseline content when appropriate (CMS, site settings, demo data), **or** import `myauto_torque_db.sql`, **or** run:

   ```bash
   php artisan db:generate-mysql-baseline-data   # refreshes baseline INSERTs from seed HTML
   ```

   ```bash
   php artisan db:seed --force
   ```

3. Optional: export a **full** dump from phpMyAdmin or:

   ```bash
   mysqldump -u USER -p myauto_torque > /path/to/backup.sql
   ```

   Keep large dumps **out of git** if they contain real customer data; store in secure backup storage.

---

## If you import `myauto_torque_db.sql` manually

1. Create the database (utf8mb4) and import the file.
2. Laravel expects a `migrations` table. After import, either:
   - run `php artisan migrate` (should no-op if schema matches), or  
   - insert rows into `migrations` for each `database/migrations/*.php` already reflected in the DB (maintenance window — only if you know each change is applied).

3. Run `php artisan db:seed --force` if you still need extra seeders beyond what is in the SQL file.

---

## Environment

Default database name in `.env.example`: **`myauto_torque`**. Adjust `USE \`myauto_torque\`` in SQL files if your server uses another name.

---

## First admin (temporary `/bootstrap-admin`)

Same idea as Prestige `CREATE_ADMIN_TEMP.php`: enable **`ADMIN_BOOTSTRAP_ENABLED=true`** in `.env`, open **`/bootstrap-admin`**, create the first admin (Spatie role `admin`), then set **`ADMIN_BOOTSTRAP_ENABLED=false`** and remove the `if (config('app.admin_bootstrap_enabled')) { ... }` block from `routes/web.php` so the URL is gone.

Routes are **not** registered when the flag is false (they will not appear in `php artisan route:list` until enabled).
