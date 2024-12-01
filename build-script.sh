#!/bin/bash

# Pull the latest changes from the git repository
git fetch origin main
git reset --hard origin/main
git clean -df

# Install/update composer dependecies
composer install
composer dump-autoload

php artisan migrate 

php artiasn config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear