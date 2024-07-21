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
	if [ ! -f "phpstan.neon" ]; then cp phpstan.dist.neon phpstan.neon; fi
	if [ ! -f ".env.local" ]; then cp .env .env.local; fi
	if [ ! -d "vendor" ]; then make install; fi

.SILENT:
check-databases-are-healthy:
	# MySQL
	while [ $$(docker inspect --format "{{json .State.Health.Status }}" $$($(DOCKER_COMPOSE) ps -q mysql)) != "\"healthy\"" ]; do printf "."; sleep 1; done

.SILENT:
reset: ## Reset generated files from distributable sources
	rm -rf docker-compose.yaml phpunit.xml phpstan.neon .php-cs-fixer.php .env.local
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
	@make check-databases-are-healthy
	@make migrations

.PHONY: start/force
start/force: ## Start and run project forcing container contextual rebuild and distributable files regeneration.
	@make reset
	$(DOCKER_COMPOSE) up -d --build --force-recreate
	@make check-databases-are-healthy
	@make migrations

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
	docker exec --user=$$(id -u):$$(id -g) $(DOCKER_CONTAINER) ./vendor/bin/php-cs-fixer fix --dry-run --diff --config .php-cs-fixer.php $$(git log --stat -1 --name-only --diff-filter=d | egrep '\.php$$' || echo -n "")
	docker exec --user=root:root $(DOCKER_CONTAINER) ./vendor/bin/phpstan clear-result-cache -c phpstan.neon --quiet
	docker exec --user=$$(id -u):$$(id -g) $(DOCKER_CONTAINER) ./vendor/bin/phpstan analyse -c phpstan.neon $$(git log --stat -1 --name-only --diff-filter=d | egrep '\.php$$' || echo -n "")

.PHONY: style/analyse
style/analyse: ## Analyse code errors statically
	docker exec --user=root:root $(DOCKER_CONTAINER) ./vendor/bin/phpstan clear-result-cache -c phpstan.neon --quiet
	docker exec --user=$$(id -u):$$(id -g) $(DOCKER_CONTAINER) ./vendor/bin/phpstan analyse -c phpstan.neon $$(git log --stat -1 --name-only --diff-filter=d | egrep '\.php$$' || echo -n "")

.PHONY: style/code-style
style/code-style: ## Analyse code style
	docker exec --user=$$(id -u):$$(id -g) $(DOCKER_CONTAINER) ./vendor/bin/php-cs-fixer fix --dry-run --diff --config .php-cs-fixer.php $$(git log --stat -1 --name-only --diff-filter=d | egrep '\.php$$' || echo -n "")

.PHONY: style/fix
style/fix: ## Fix code style
	docker exec --user=$$(id -u):$$(id -g) $(DOCKER_CONTAINER) ./vendor/bin/php-cs-fixer fix --config .php-cs-fixer.php $$(git log --stat -1 --name-only --diff-filter=d | egrep '\.php$$' || echo -n "")

#
# 🛢 Database
#

.PHONY: migrations
migrations: ## Execute database migrations
	docker exec --user=$$(id -u):$$(id -g) $(DOCKER_CONTAINER) php bin/console doctrine:migrations:migrate --no-interaction --quiet --allow-no-migration

.PHONY: migrations-prev
migrations-prev: ## Rollback the last migration
	docker exec --user=$$(id -u):$$(id -g) $(DOCKER_CONTAINER) php bin/console doctrine:migrations:migrate prev --no-interaction --quiet --allow-no-migration