#!/bin/bash

RUN php artisan migrate

RUN php artisan db:seed

exec "$@"