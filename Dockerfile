FROM php:8.2.5

COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

COPY . /var/www/html

EXPOSE 8080

CMD ["symfony", "server:start", "--no-tls"]

