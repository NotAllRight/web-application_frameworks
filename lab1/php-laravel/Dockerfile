FROM webdevops/php-apache-dev:8.2

WORKDIR /app
COPY . /app

RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

CMD php artisan migrate --force && supervisord
