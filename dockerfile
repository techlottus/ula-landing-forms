FROM php:8.2-cli
COPY . /app
WORKDIR /app
CMD [ "php", "./your-script.php" ]