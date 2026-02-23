#!/usr/bin/env bash
set -e

echo "Running migrations..."
php artisan migrate --force

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Caching views..."
php artisan view:cache

echo "Optimizing..."
php artisan optimize

# Storage link jika belum ada
php artisan storage:link 2>/dev/null || true

echo "Starting services..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
