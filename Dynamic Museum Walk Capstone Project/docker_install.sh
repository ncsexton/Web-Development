#!/bin/bash

[[ ! -e /.dockerenv ]] && exit 0

set -xe

apt-get update -yqq
apt-get install git -yqq

curl --location --output /usr/local/bin/phpunit "https://phar.phpunit.de/phpunit.phar"
chmod +x /usr/local/bin/phpunit

docker-php-ext-install pdo_mysql
