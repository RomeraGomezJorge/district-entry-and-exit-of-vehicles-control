FROM composer:2 as composer_stage

RUN rm -rf /var/www && mkdir -p /var/www/
WORKDIR /var/www/

FROM php:7.4-fpm

# Install packages and PHP extensions
RUN apt update \
    && apt-get install -y git acl openssl openssh-client wget zip vim librabbitmq-dev libssh-dev default-mysql-client \
    && apt-get install -y libpng-dev zlib1g-dev libzip-dev libxml2-dev libicu-dev \
    && docker-php-ext-install intl pdo pdo_mysql zip soap bcmath sockets gd \
    && docker-php-ext-enable --ini-name 05-opcache.ini opcache

# Install and update composer
RUN curl https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer
RUN composer self-update

# Install PHP-CS-FIXER
RUN curl -sL -o /usr/local/bin/phpcs https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar && chmod +x /usr/local/bin/phpcs
RUN curl -sL -o /usr/local/bin/phpcbf https://squizlabs.github.io/PHP_CodeSniffer/phpcbf.phar && chmod +x /usr/local/bin/phpcbf

RUN mkdir -p /var/www/

WORKDIR /var/www

# Config XDEBUG
COPY docker/php-fpm/xdebug.ini  /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY docker/php-fpm/error_reporting.ini /usr/local/etc/php/conf.d/error_reporting.ini

COPY --from=composer_stage /var/www/ /var/www/

COPY app ./


