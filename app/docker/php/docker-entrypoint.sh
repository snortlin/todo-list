#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ] || [ "$1" = 'bin/console' ] || { [ "$1" = 'php' ] && [ "$2" = 'bin/console' ]; }; then
	# Files permissions
	mkdir -p var/cache var/log
	chmod -R 777 var

	# dev-actions
	if [ "$APP_ENV" == 'dev' ]; then
		echo "Configuring PHP for development"
		cp "${PHP_INI_DIR}/php.ini-development" "$PHP_INI_DIR/php.ini"

		echo "Install project dependencies"
		composer install --prefer-dist --no-progress --no-interaction

		echo "Run custom script"
		chmod +x docker/app/dev/run.sh
		sh docker/app/dev/run.sh
	fi

  # prod-actions
	if [ "$APP_ENV" == 'prod' ]; then
		echo "Run custom script"
		chmod +x docker/app/prod/run.sh
		sh docker/app/prod/run.sh
	fi
fi

exec docker-php-entrypoint "$@"
