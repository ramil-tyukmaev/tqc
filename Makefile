# Makefile

.PHONY: init

init:
	cp ./.env.example ./.env
	docker compose run --build --rm --entrypoint="sh -c '/usr/local/bin/composer install && /usr/local/bin/php /var/www/artisan migrate'" app
