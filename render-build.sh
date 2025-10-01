#!/usr/bin/env bash
# exit on error
set -o errexit

# Install dependencies
composer install --no-dev --optimize-autoloader

# Generate application key if not exists
php artisan key:generate --no-interaction

# Clear and cache config
php artisan config:clear
php artisan config:cache

# Clear and cache routes
php artisan route:clear
php artisan route:cache

# Clear and cache views
php artisan view:clear
php artisan view:cache

# Create storage link
php artisan storage:link

# Run migrations
php artisan migrate --force

# Seed database if needed (comment out in production if not needed)
# php artisan db:seed --force

# Optimize for production
php artisan optimize
