SHELL = /bin/bash
DOCKER_CONTAINER = beta-readers-api-webserver
DOCKER_COMPOSER = docker run --rm --interactive --tty --volume $$PWD:/app --user $$(id -u):$$(id -g) composer
DOCKER_COMPOSE = docker compose -f docker-compose.yaml

CURRENT_UID := $(shell id -u)
CURRENT_GROUP := $(shell id -g)
export CURRENT_UID
export CURRENT_GROUP

# Colors
NC := '\033[0m'
RED := '\033[0;31m'

#
# ❓ Help output
#
help: ## Show make targets
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_\-\/]+:.*?## / {sub("\\\\n",sprintf("\n%22c"," "), $$2);printf " \033[36m%-24s\033[0m  %s\n", $$1, $$2}' $(MAKEFILE_LIST)

setup: ## Copy app bootstrap necessary files and install deps
	if [ ! -f "docker-compose.yaml" ]; then cp docker-compose.dist.yaml docker-compose.yaml; fi
	if [ ! -f "phpunit.xml" ]; then cp phpunit.xml.dist phpunit.xml; fi
	if [ ! -f ".php-cs-fixer.php" ]; then cp .php-cs-fixer.dist.php .php-cs-fixer.php; fi
	if [ ! -f ".env.local" ]; then cp .env .env.local; fi
	if [ ! -d "vendor" ]; then make install; fi

package-name: ## Capture package to install through composer
	if [ ! -v PACKAGE ]; then printf ${RED}"PACKAGE not specified... PACKAGE=<package-name> make package/add"${NC}"\nº"; exit 1; fi

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
start/force: ## Start and run project forcing container contextual rebuild
	@make files
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
	docker exec --user=$(CURRENT_UID):$(CURRENT_GROUP) -it $(DOCKER_CONTAINER) bash

#
# 🧪 Testing
#
.PHONY: unit
unit: ## Run unitary tests suite
	docker exec --user=$(CURRENT_UID):$(CURRENT_GROUP) $(DOCKER_CONTAINER) ./vendor/bin/phpunit -c phpunit.xml

#
# 💅 Style
#
.PHONY: style/all
style/all: ## Analyse code style and possible errors
	docker exec --user=$(CURRENT_UID):$(CURRENT_GROUP) $(DOCKER_CONTAINER) ./vendor/bin/php-cs-fixer fix --dry-run --diff --config .php-cs-fixer.php
	docker exec --user=$(CURRENT_UID):$(CURRENT_GROUP) $(DOCKER_CONTAINER) ./vendor/bin/phpstan analyse -c phpstan.neon

.PHONY: style/code-style
style/code-style: ## Analyse code style
	docker exec --user=$(CURRENT_UID):$(CURRENT_GROUP) $(DOCKER_CONTAINER) ./vendor/bin/php-cs-fixer fix --dry-run --diff --config .php-cs-fixer.php

.PHONY: style/fix
style/fix: ## Fix code style
	docker exec --user=$(CURRENT_UID):$(CURRENT_GROUP) $(DOCKER_CONTAINER) ./vendor/bin/php-cs-fixer fix --config .php-cs-fixer.php