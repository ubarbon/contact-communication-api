#!/usr/bin/env bash
#Setup/install the application for tests, ONLY run in local environment
set -e

echo "Installing dependency(vendor) of Synergy App Api"
composer install

php bin/console doctrine:database:drop --if-exists --force
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --dump-sql --force
php bin/console doctrine:fixtures:load -n

#Here can be executed automatically the test with phpunit, right now phpunit is executed in demand