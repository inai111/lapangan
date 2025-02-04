FROM dunglas/frankenphp:latest-php8.2

RUN install-php-extensions \
    pdo_mysql \
    gd \
    intl \
    zip

