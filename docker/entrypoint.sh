#!/bin/bash

RUN composer install

RUN php artisan migrate

RUN php artisan db:seed

exec "$@"