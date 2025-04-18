FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    cron \
    nginx \
    libpq-dev \
    supervisor \
    procps \
    && apt-get clean

RUN docker-php-ext-install pdo pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./build/crontab /etc/cron.d/laravel-cron

RUN chmod 0644 /etc/cron.d/laravel-cron

RUN crontab /etc/cron.d/laravel-cron

WORKDIR /var/www

ENTRYPOINT ./build/entrypoint.sh
