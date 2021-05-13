#!/bin/sh
set -e

echo "Waiting for db..."
until bin/console doctrine:query:sql "SELECT true" > /dev/null 2>&1; do
	sleep 1
done

echo "Running migrations"
bin/console doctrine:migrations:migrate --no-interaction
