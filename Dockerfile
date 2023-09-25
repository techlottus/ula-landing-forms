# FROM php:7.1.3-fpm
# VOLUME [ "/var/www/html/vendor" ]
# # RUN apt-get update && apt-get install -y libmcrypt-dev \
# #     mysql-client libmagickwand-dev --no-install-recommends \
# #     && pecl install imagick \
# #     && docker-php-ext-enable imagick \
# # && docker-php-ext-install mcrypt pdo_mysql

# # Install Composer
# RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/ --filename=composer

# CMD bash -c "php artisan serve --host 0.0.0.0 --port 5001"


FROM php:7.1-fpm-alpine
VOLUME [ "./:/var/www" ]
# RUN addgroup -g 0 --system laravel
# RUN adduser -G laravel --system -D -s /bin/sh -u 0 laravel

RUN sed -i "s/user = www-data/user = root/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = root/g" /usr/local/etc/php-fpm.d/www.conf


RUN apk update && apk add curl && \
  curl -sS https://getcomposer.org/installer | php \
  && chmod +x composer.phar && mv composer.phar /usr/local/bin/composer

RUN apk --no-cache add --virtual .build-deps $PHPIZE_DEPS \
  && apk --no-cache add --virtual .ext-deps libmcrypt-dev freetype-dev \
  libjpeg-turbo-dev libpng-dev libxml2-dev msmtp bash openssl-dev pkgconfig \
  && docker-php-source extract \
  && docker-php-ext-install opcache \
  && docker-php-source delete \
  && apk del .build-deps

WORKDIR  /var/www/


ENV UID=0
ENV GID=0

# RUN composer dump-autoload --optimize && composer run-script post-install-cmd

CMD bash -c "composer install && php serve --host 0.0.0.0 --port 5001"