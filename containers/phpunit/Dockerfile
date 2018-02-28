FROM php:7.1.5-fpm-alpine

# Timezone and locale
ENV TIMEZONE Europe/Moscow
ENV TZ Europe/Moscow
ENV XDEBUG_VERSION 2.5.4

RUN apk update \
    && apk add postgresql-dev libxml2-dev tzdata\
    && apk add zlib-dev \
    && apk add curl-dev \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install soap \
    && docker-php-ext-install zip curl mbstring tokenizer \
    && apk del postgresql-dev \
    && cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime  \
    && echo "${TIMEZONE}" > /etc/timezone \
    && apk del tzdata \
    && apk add libpq

# add app user
RUN adduser -D -u 1000 appuser \
    && addgroup appuser www-data \
    && addgroup www-data appuser

# add xdebug
RUN apk add --update wget ca-certificates openssl autoconf gcc g++ binutils make \
    && wget https://xdebug.org/files/xdebug-$XDEBUG_VERSION.tgz \
    && tar -zxvf xdebug-$XDEBUG_VERSION.tgz \
    && rm -f xdebug-$XDEBUG_VERSION.tgz \
    && cd xdebug-$XDEBUG_VERSION && phpize \
    && ./configure --enable-xdebug && make \
    && cp modules/xdebug.so /usr/local/lib/php/extensions/xdebug.so \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" >> /usr/local/etc/php/php.ini \
    && echo 'xdebug.remote_enable=on' >> /usr/local/etc/php/php.ini \
    && echo 'xdebug.remote_host=localhost' >> /usr/local/etc/php/php.ini \
    && echo 'xdebug.remote_port=9000' >> /usr/local/etc/php/php.ini \
    && echo 'xdebug.remote_handler=dbgp' >> /usr/local/etc/php/php.ini \
    && echo 'xdebug.profiler_enable=0' >> /usr/local/etc/php/php.ini \
    && echo 'xdebug.remote_log=/app/log/xdebug_remote.log' >> /usr/local/etc/php/php.ini \
    # это нужно для того чтобы в рантайме переопределять xdebug.remote_host
    && chown appuser:appuser /usr/local/etc/php/php.ini \
    && apk del wget ca-certificates autoconf gcc g++ binutils make
# add composer
RUN php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer \
    && echo 'date.timezone = ${TIMEZONE}' >> /usr/local/etc/php/php.ini

# add phpunit
RUN wget https://phar.phpunit.de/phpunit-6.3.0.phar \
    && chmod +x phpunit-6.3.0.phar \
    && mv phpunit-6.3.0.phar /usr/local/bin/phpunit

COPY ./run.sh /app/
RUN chmod +x /app/run.sh

USER 1000

WORKDIR /app/htdocs

CMD ["/app/run.sh"]
