FROM php:7.2-cli-alpine

RUN apk add --no-cache $PHPIZE_DEPS \
	&& pecl install xdebug-2.6.0 \
	&& docker-php-ext-enable xdebug

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY entrypoint.sh /usr/bin/entrypoint.sh
RUN chmod 755 /usr/bin/entrypoint.sh

CMD /usr/bin/entrypoint.sh