FROM php:latest
COPY ./app /app
WORKDIR /app
RUN apt-get update && apt-get install -y \
    zip \
    unzip
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer
RUN composer require vlucas/phpdotenv
ENV GRANT_TYPE='Hello World!'

CMD ["php", "-S", "0.0.0.0:80", "./test.php" ]
# CMD [ "cat",  ".env" ]