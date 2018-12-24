#!/usr/bin/env bash
#ONLY run in local environment
#Setup/install the application for tests, ONLY run in local environment
set -e

sh ./local_install.sh
php bin/console doctrine:fixtures:load -n

#phpunit global install is required
phpunit