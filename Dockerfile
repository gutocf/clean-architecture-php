FROM php:8.4-apache
RUN a2enmod rewrite
RUN apt-get update
RUN apt-get update && apt-get install -y git
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions gd pdo pdo_mysql bcmath zip intl gettext
COPY --from=composer:2.0 /usr/bin/composer /usr/local/bin/composer
COPY .docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY .docker/php/docker-php-memory-limit.ini /usr/local/etc/php/conf.d/docker-php-memory-limit.ini