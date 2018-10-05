#!/bin/sh

[[ -d vendor ]] || composer install

php -d "xdebug.remote_enable=1" -d "xdebug.remote_autostart=1" -d "xdebug.remote_host=$XDEBUG_HOST" \
    -d "xdebug.remote_port=$XDEBUG_PORT" -d "xdebug.idekey=$XDEBUG_IDEKEY"  \
    vendor/bin/phpunit