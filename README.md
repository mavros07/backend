# MyAuto-Torque (Laravel backend)

Full **site behavior, feature list, and codebase map**: see **[docs/SITE_AND_CODEBASE.md](docs/SITE_AND_CODEBASE.md)**.

## Requirements

- PHP 8.2+
- Composer
- Node.js (for Vite)

## Environment

Copy `.env.example` to `.env`. **All mail and DB settings are intended to live in `.env`** (Laravel reads them through `config/*.php`).

### Database (production: MySQL)

Set `DB_CONNECTION=mysql` and your `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.

Create tables on the server:

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
```

(Optional) Export **MySQL** `CREATE TABLE` statements after migrations (no `mysqldump` required):

```bash
php artisan schema:export-mysql --path=database/schema.mysql.sql
```

The file `database/schema.sql` is **SQLite-only** (for local dev when `DB_CONNECTION=sqlite`). It is not “empty”; it uses SQLite syntax (`AUTOINCREMENT`, quoted identifiers). MySQL will not run that file.

### Outbound mail (ZeptoMail API + PHPMailer backup)

This matches the **Resmenu** pattern: **ZeptoMail HTTP API first**, then **PHPMailer SMTP** as a separate backup if the API fails or is not configured.

| Purpose | Environment variables |
| --- | --- |
| ZeptoMail API (primary) | `ZEPTOMAIL_SENDMAIL_TOKEN`, `ZEPTOMAIL_URL`, `ZEPTOMAIL_TIMEOUT_SECONDS`, `ZEPTOMAIL_FROM_ADDRESS`, `ZEPTOMAIL_FROM_NAME`, `ZEPTOMAIL_REPLY_TO` |
| PHPMailer SMTP (backup) | `MAIL_PHPMAILER_ENABLED`, `MAIL_PHPMAILER_HOST`, `MAIL_PHPMAILER_PORT`, `MAIL_PHPMAILER_USERNAME`, `MAIL_PHPMAILER_PASSWORD`, `MAIL_PHPMAILER_ENCRYPTION` |
| From + admin inbox | `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME`, `MAIL_TO_ADMIN` |

`ZEPTOMAIL_SENDMAIL_TOKEN` may be pasted as either the raw token or `Zoho-enczapikey <token>` (both are accepted).

## Install and run locally

```bash
composer install
npm install
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
npm run dev
php artisan serve
```

`php artisan storage:link` is required for uploaded vehicle gallery images because listing photos are stored on Laravel's public disk and served from `/storage/...`.

## Default seeded users

Defined in `database/seeders/DemoData.php` (run via `DatabaseSeeder`):

- Admin: `admin@example.com` / `password`
- User: `demo@example.com` / `password`
