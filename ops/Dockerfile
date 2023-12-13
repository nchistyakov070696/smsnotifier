FROM alpine:3.19.0

RUN apk add --no-cache \
        php82 \
        php82-apache2 \
        php82-curl \
        php82-dom \
        php82-mbstring \
        php82-pdo \
        php82-pgsql \
        php82-pdo_pgsql \
        php82-session \
        php82-sockets \
        php82-tokenizer \
        php82-xml \
        php82-xmlwriter \
        php82-xmlreader \
        php82-fileinfo \
        php82-simplexml \
        php82-ctype \
        php82-gd \
        php82-iconv \
        php82-zip \
        php82-json \
        php82-openssl \
        php82-pecl-xdebug \
        php82-pecl-amqp \
        php82-phar

RUN apk add  --no-cache \
        apache2 \
        curl \
        php82-zlib \
        postgresql-client \
        rabbitmq-c \
        rabbitmq-c-dev \
    && mkdir -p /run/apache2 \
    && ln -sf /dev/stdout /var/log/apache2/access.log \
    && ln -sf /dev/stderr /var/log/apache2/error.log

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN sed -e 's/memory_limit = 128M/memory_limit = 256M/' -i /etc/php82/php.ini

WORKDIR /app

COPY ops/apache2.conf /etc/apache2/conf.d

COPY ops/web.sh /run-web.sh
RUN chmod 755 /run-*.sh

COPY ops/xdebug.ini /etc/php82/conf.d/xdebug.ini

EXPOSE 80 443

CMD /run-web.sh
