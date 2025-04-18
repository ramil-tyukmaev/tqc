# Makefile

.PHONY: init

init:
	docker compose run --rm --entrypoint="/usr/local/bin/composer install" app
	cp ./.env.example ./.env
