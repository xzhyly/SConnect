#!/bin/bash
set -e

echo "========================================"
echo "  ScholarConnect — Container Startup"
echo "========================================"

cd /var/www

# ── Step 1: Install PHP dependencies ─────────────────────────────────
echo "[1/5] Installing Composer dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# ── Step 2: Copy .env if missing ─────────────────────────────────────
if [ ! -f ".env" ]; then
    echo "[2/5] Creating .env from .env.example..."
    cp .env.example .env
else
    echo "[2/5] .env already exists, skipping."
fi

# ── Step 3: Generate app key if not set ──────────────────────────────
APP_KEY_VALUE=$(grep "^APP_KEY=" .env | cut -d '=' -f2)
if [ -z "$APP_KEY_VALUE" ]; then
    echo "[3/5] Generating application key..."
    php artisan key:generate
else
    echo "[3/5] APP_KEY already set, skipping."
fi

# ── Step 4: Run migrations and seed ──────────────────────────────────
echo "[4/5] Running migrations and seeding database..."
until php artisan migrate:fresh --seed --force 2>/dev/null; do
    echo "      Database not ready yet, retrying in 5s..."
    sleep 5
done
echo "      Done."

# ── Step 5: Start queue worker then serve ────────────────────────────
echo "[5/5] Starting queue worker and HTTP server..."
php artisan queue:work --daemon --tries=3 &

echo ""
echo "========================================"
echo "  App running at http://localhost:8000"
echo "  Admin : admin@scholarconnect.test"
echo "  Pass  : password"
echo "========================================"
echo ""

php artisan serve --host=0.0.0.0 --port=8000