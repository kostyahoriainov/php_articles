#!/usr/bin/env bash

npm install &
npm run watch &

docker-php-entrypoint php-fpm