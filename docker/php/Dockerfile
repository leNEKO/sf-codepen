FROM php:7.2-fpm

ARG TZ
ENV TZ ${TZ}
RUN echo $TZ

ARG LOCAL_USER
ENV LOCAL_USER ${LOCAL_USER}
RUN echo $LOCAL_USER


RUN docker-php-ext-install pdo_mysql

RUN pecl install apcu \
    && docker-php-ext-enable apcu

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN mkdir /tmp/xdebug \
    && chmod -R ugo+rw /tmp/ \
    && chown -R $LOCAL_USER /tmp/

RUN docker-php-ext-enable opcache

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Timezone
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "%s"\n' "$TZ" > /usr/local/etc/php/conf.d/tzone.ini

WORKDIR /var/www/symfony

RUN PATH=$PATH:/var/www/symfony/vendor/bin:bin
