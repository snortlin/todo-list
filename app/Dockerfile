ARG PHP_VERSION=8.0
ARG ALPINE_VERSION=3.13

FROM php:${PHP_VERSION}-fpm-alpine${ALPINE_VERSION}

# Persistent / Runtime dependencies
RUN apk update && \
	apk add --no-cache \
		curl \
		file \
		git \
		htop \
		mc \
		nano

# PHP env settings
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=0
ENV PHP_DATE_TIMEZONE=${TIMEZONE}

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# PHP dependencies
RUN install-php-extensions \
		apcu \
		# mbstring \ # mbstring and oniguruma are included in base image
		opcache	\
		pdo_pgsql

# PHP configuration (default production configuration)
RUN ln -s "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY docker/php/conf.d/* $PHP_INI_DIR/conf.d/

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH="${PATH}:/root/.composer/vendor/bin"

# App
WORKDIR /var/www/app

# Build for production
ARG APP_ENV=prod

# Prevent the reinstallation of vendors at every changes in the source code
COPY composer.json composer.lock symfony.lock ./

# Install app for production
RUN set -eux; \
	composer install --prefer-dist --no-dev --no-progress --no-scripts --no-interaction; \
	composer clear-cache

COPY . ./

RUN set -eux; \
	mkdir -p var/cache var/log; \
	composer dump-autoload --classmap-authoritative --no-dev; \
	composer symfony:dump-env prod; \
	composer run-script --no-dev post-install-cmd; \
	chmod +x bin/console; sync

COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]
