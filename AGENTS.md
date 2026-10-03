# AGENTS.md — Base44 dev environment notes

## Project
Laravel 11 + Filament v3 app for **UFEEL** (Union Fraternelle des Élèves et Étudiants de Lafi). PHP 8.4, PostgreSQL, Blade views, Sanctum API auth.

## Running the app
```
docker compose -f docker-compose.base44.yml up -d
```
- **Web** (port 3000): `php artisan serve --host=0.0.0.0 --port=3000 --no-reload` — Blade/PHP changes take effect on next request (no restart needed).
  **IMPORTANT:** `artisan serve` must run with `--no-reload` — without it, ServeCommand strips all env vars except a small passthrough list (APP_ENV, PATH…) from its `php -S` worker, so the worker falls back to the repo `.env` (`DB_CONNECTION=sqlite`) instead of the compose-provided PostgreSQL env. Symptom: API/web reads an empty sqlite DB while `docker compose exec web php artisan tinker` sees the pgsql data.
- **DB**: PostgreSQL 16 (`ufeel` db, `ufeel` user, password `ufeel_dev_pass`).
- Migrations + seeders (AdminSeeder, SiteStatSeeder) run automatically on container start.

## Key URLs
- `/` — public homepage
- `/admin` — Filament admin panel (login: `admin@ufeel.ci` / `ufeel2026admin`)
- `/up` — health check
- `/api/*` — Sanctum API routes

## External services (optional, not required to boot)
- **OPENAI_API_KEY** — powers the AI conversation feature.
- **CINETPAY_API_KEY** + **CINETPAY_SITE_ID** — powers membership subscription payments.

## Dockerfile
`Dockerfile.base44` builds from `php:8.4-cli` with extensions: pdo_pgsql, gd, intl, zip, exif, bcmath, mbstring, fileinfo. Source is bind-mounted (not baked in) so edits are live.

## Notes
- `vendor/` is committed to the repo, so no composer install is needed at startup.
- The repo `.env` uses SQLite, but the compose `environment:` overrides it to PostgreSQL.
- `storage:link` is created on each start via `--force`.
