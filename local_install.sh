#!/usr/bin/env bash
#ONLY run in local environment
#Setup/install the application local/dev environment
set -e

echo "Installing dependency(vendor) of Contact Communication App Api"
composer install

php bin/console doctrine:database:drop --if-exists --force
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --dump-sql --force
