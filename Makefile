CONTAINER ?= $(LIST_CONTAINERS)
TEST_CLASS ?= .
LIST_CONTAINERS ?= webserver blog ms_auth ms_posts

.PHONY: up
up:
	docker compose up -d --force-recreate

.PHONY: start
start: up
	$(foreach CONT, $(LIST_CONTAINERS), \
		docker exec -it $(CONT) bash -c 'php artisan migrate --force'; \
	)

.PHONY: stop
stop:
	docker compose down $(CONTAINER)

.PHONY: down
down: stop
	docker system prune --force && \
	docker rmi $$(docker images -q)

.PHONY: restart
restart:
	$(foreach CONT, $(LIST_CONTAINERS), \
		docker compose build $(CONT) && docker compose up -d $(CONT); \
	)

.PHONY: restartc
restartc:
	docker compose build $(CONTAINER) && docker compose up -d $(CONTAINER); \

.PHONY: test
test: restart_php
	pest
	cache

.PHONY: pest
pest:
	docker exec -it $(CONTAINER) bash -c 'php ./vendor/bin/pest --filter=$(TEST_CLASS)'

.PHONY: pint
pint:
	docker exec -it $(CONTAINER) bash -c 'php ./vendor/bin/pint src'

.PHONY: phpstan
phpstan: restart_php
	docker exec -it $(CONTAINER) bash -c './vendor/bin/phpstan analyse --memory-limit=2G src/Post/Infrastructure/Controller'

.PHONY: key-genrate
key-generate:
	docker exec -it $(CONTAINER) bash -c 'php artisan key:generate'

.PHONY: cache
cache:
	$(foreach CONT, $(LIST_CONTAINERS), \
		docker exec -it $(CONT) bash -c 'php artisan view:clear'; \
		docker exec -it $(CONT) bash -c 'php artisan route:cache'; \
		docker exec -it $(CONT) bash -c 'php artisan config:clear'; \
		docker exec -it $(CONT) bash -c 'php artisan clear-compiled'; \
		docker exec -it $(CONT) bash -c 'php artisan optimize'; \
		docker exec -it $(CONT) bash -c 'php artisan config:cache'; \
	)
	
.PHONY: migrate
migrate:
	docker exec -it $(CONTAINER) bash -c 'php artisan migrate --force'

.PHONY: restart_db
restart_db: migrate
	docker exec -it $(CONTAINER) bash -c 'php artisan migrate:refresh'

.PHONY: bash
bash:
	docker exec -it $(CONTAINER) bash

.PHONY: routes
routes:
	docker exec -it $(CONTAINER) bash -c 'php artisan route:cache'
	docker exec -it $(CONTAINER) bash -c 'php artisan route:list'

.PHONY: dumpautoload
dumpautoload:
	docker exec -it $(CONTAINER) composer dumpautoload
	make restart_php

.PHONY: openapi
openapi:
	docker exec -it $(CONTAINER) bash -c 'php artisan openapi:generate --env docs --verbose'

.PHONY: serve
serve:
	docker exec -it $(PHP_GATEWAY_NAME) bash -c 'php -S localhost:8002 -t .\public'

.PHONY: composer_install
composer_install:
	docker exec -it $(CONTAINER) bash -c 'composer install'

.PHONY: composer_update
composer_update:
	docker exec -it $(CONTAINER) bash -c 'composer update'
