FROM php:7.1.5-fpm-alpine

# Timezone and locale
ENV TIMEZONE Europe/Moscow
ENV TZ Europe/Moscow

RUN apk update \
    && apk add postgresql-dev libxml2-dev tzdata zlib-dev curl-dev \
    && docker-php-ext-install pdo_pgsql soap \
    && docker-php-ext-install zip curl mbstring tokenizer \
    && cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime  \
    && echo "${TIMEZONE}" > /etc/timezone \
    && apk del tzdata \
    && apk del postgresql-dev \
    && apk add libpq


# add app user
RUN adduser -D -u 1000 appuser \
    && addgroup appuser www-data \
    && addgroup www-data appuser

# add composer
RUN php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer \
    && echo 'date.timezone = ${TIMEZONE}' >> /usr/local/etc/php/php.ini
USER 1000

env PATH /home/appuser/.composer/vendor/bin/:$PATH

WORKDIR /app/htdocs
