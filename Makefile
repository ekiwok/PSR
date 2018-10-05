test:
	vendor/bin/phpunit

test-xdebug:
	docker-compose run --rm php