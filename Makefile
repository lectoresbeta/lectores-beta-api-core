SHELL = /bin/bash
DOCKER_CONTAINER = beta-readers-api-webserver
DOCKER_COMPOSER  = docker run --rm --interactive --tty --volume $$PWD:/app --user $$(id -u):$$(id -g) composer
DOCKER_COMPOSE   = CURRENT_UID=$$(id -u) CURRENT_GROUP=$$(id -g) docker compose -f docker-compose.yaml --env-file $$PWD/.docker/config/.env.build

# Colors
NC := '\033[0m'
RED := '\033[0;31m'

#
# ❓ Help output
#
help: ## Show make targets
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_\-\/]+:.*?## / {sub("\\\\n",sprintf("\n%22c"," "), $$2);printf " \033[36m%-24s\033[0m  %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.SILENT:
setup: ## Copy app bootstrap necessary files and install deps
	if [ ! -f "docker-compose.yaml" ]; then cp docker-compose.dist.yaml docker-compose.yaml; fi
	if [ ! -f "phpunit.xml" ]; then cp phpunit.xml.dist phpunit.xml; fi
	if [ ! -f ".php-cs-fixer.php" ]; then cp .php-cs-fixer.dist.php .php-cs-fixer.php; fi
	if [ ! -f ".env.local" ]; then cp .env .env.local; fi
	if [ ! -d "vendor" ]; then make install; fi

.SILENT:
reset: ## Reset generated files from distributable sources
	rm -rf docker-compose.yaml phpunit.xml .php-cs-fixer.php .env.local
	@make setup
	@make install

.SILENT:
package-name: ## Capture package to install through composer
	if [ ! -v PACKAGE ]; then printf ${RED}"PACKAGE not specified... PACKAGE=<package-name> make package/add"${NC}"\nº"; exit 1; fi

.SILENT:
show-containers: ## List all our active containers
	$(DOCKER_COMPOSE) ps

#
# 🐘 Build and run
#
.PHONY: start
start: ## Start and run project
	@make setup
	$(DOCKER_COMPOSE) up -d

.PHONY: start/force
start/force: ## Start and run project forcing container contextual rebuild and distributable files regeneration.
	@make reset
	$(DOCKER_COMPOSE) up -d --build --force-recreate

.PHONY: stop
stop: ## Stop project
	$(DOCKER_COMPOSE) down --remove-orphans --volumes

.PHONY: install
install: ## Install dependencies
	$(DOCKER_COMPOSER) install

.PHONY: package/add
package/add: ## Install new package through composer
	@make package-name
	$(DOCKER_COMPOSER) composer require ${PACKAGE} ${FLAGS}

.PHONY: bash
bash: ## Enter to the php-fpm container
	docker exec --user=$$(id -u):$$(id -g) -it $(DOCKER_CONTAINER) bash

#
# 🧪 Testing
#
.PHONY: test/unit
test/unit: ## Run unitary tests suite
	docker exec --user=$$(id -u):$$(id -g) $(DOCKER_CONTAINER) ./vendor/bin/phpunit -c phpunit.xml --testdox --testsuite=unitary

.PHONY: test/acceptance
test/acceptance: ## Run acceptance tests suite
	docker exec --user=$$(id -u):$$(id -g) $(DOCKER_CONTAINER) ./vendor/bin/phpunit -c phpunit.xml --testdox --testsuite=acceptance

#
# 💅 Style
#
.PHONY: style/all
style/all: ## Analyse code style and possible errors
	docker exec --user=$$(id -u):$$(id -g) $(DOCKER_CONTAINER) ./vendor/bin/php-cs-fixer fix --dry-run --diff --config .php-cs-fixer.php
	docker exec --user=$$(id -u):$$(id -g) $(DOCKER_CONTAINER) ./vendor/bin/phpstan analyse -c phpstan.neon

.PHONY: style/code-style
style/code-style: ## Analyse code style
	docker exec --user=$$(id -u):$$(id -g) $(DOCKER_CONTAINER) ./vendor/bin/php-cs-fixer fix --dry-run --diff --config .php-cs-fixer.php

.PHONY: style/fix
style/fix: ## Fix code style
	docker exec --user=$$(id -u):$$(id -g) $(DOCKER_CONTAINER) ./vendor/bin/php-cs-fixer fix --config .php-cs-fixer.php

#
# 🛢 Database
#

.PHONY: migrations
migrations: ## Execute database migrations
	docker exec --user=$$(id -u):$$(id -g) $(DOCKER_CONTAINER) php bin/console doctrine:migrations:migrate --no-interaction

.PHONY: migrations-prev
migrations-prev: ## Rollback the last migration
	docker exec --user=$