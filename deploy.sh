#!/bin/sh
git pull
composer install
php artisan migrate
php artisan config:cache
php artisan route:cache
php artisan optimize
php artisan queue:restart