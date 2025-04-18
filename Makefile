# Makefile

.PHONY: init

init:
	docker compose run --build --rm --entrypoint="sh -c '/usr/local/bin/composer install && /usr/local/bin/php /var/www/artisan migrate'" app
	cp ./.env.example ./.env
