#!/usr/bin/env bash

npm install
cd /
cd var/www/app
npm run watch

docker-php-entrypoint php-fpm