#!/bin/bash

chmod -R 777 /var/www/storage/logs

composer install

php artisan migrate

php artisan db:seed

php artisan storage:link

exec "$@"