#!/bin/bash

chmod -R 777 /var/www/storage

composer install

php artisan migrate

php artisan db:seed

exec "$@"