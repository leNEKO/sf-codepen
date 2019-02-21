FROM php:7.2-fpm

RUN docker-php-ext-install pdo_mysql

RUN pecl install apcu \
    && docker-php-ext-enable apcu

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

ADD ./docker/php/xdebug.ini /usr/local/etc/php/conf.d/

WORKDIR /var/www/symfony

RUN PATH=$PATH:/var/www/symfony/vendor/bin:bin
