FROM php:7.4-cli
RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin/ --filename=composer
COPY . /usr/src/dominoes
WORKDIR /usr/src/dominoes
RUN composer install --no-dev --no-interaction -o
CMD [ "php", "./app.php" ]



