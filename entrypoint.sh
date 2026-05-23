#!/bin/bash
set -e

echo "========================================"
echo "  ScholarConnect — Container Startup"
echo "========================================"

cd /var/www

# ── Step 1: Install PHP dependencies ─────────────────────────────────
echo "[1/5] Installing Composer dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# ── Step 2: Always write .env from environment variables ─────────────
echo "[2/5] Writing .env from environment..."
cat > .env << EOF
APP_NAME=ScholarConnect
APP_ENV=${APP_ENV:-production}
APP_KEY=${APP_KEY}
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-http://localhost:8000}

DB_CONNECTION=mysql
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT:-3306}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

MAIL_MAILER=${MAIL_MAILER:-smtp}
MAIL_HOST=${MAIL_HOST}
MAIL_PORT=${MAIL_PORT:-2525}
MAIL_USERNAME=${MAIL_USERNAME}
MAIL_PASSWORD=${MAIL_PASSWORD}
MAIL_FROM_ADDRESS=${MAIL_FROM_ADDRESS:-noreply@scholarconnect.test}

MOCK_API_URL=${MOCK_API_URL:-http://localhost:8080}
EOF
echo "      Done."

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