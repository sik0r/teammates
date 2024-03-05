SHELL=sh
APP_NAME=teammates
DOCKER_EXEC=docker exec -it ${APP_NAME}
COMPOSE_FILE = docker compose -f compose.yaml

help:
	@printf "\n%s\n________________________________________________\n" $(shell basename ${APP_NAME})
	@printf "\n\033[32mAvailable commands:\n\033[0m"
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep  | sed -e 's/\\$$//' | sed -e 's/##//' | awk 'BEGIN {FS = ":"}; {printf "\033[33m%s:\033[0m%s\n", $$1, $$2}'

setup: ## Setup local development environment
	cp -n .env .env.local || true
	${COMPOSE_FILE} up -d
	make install
	make install-tools
	make migrate
	make test

rebuild: ## Rebuild docker images
	${COMPOSE_FILE} build --no-cache
	${COMPOSE_FILE} up -d --force-recreate

stop: ## Stop docker containers
	${COMPOSE_FILE} stop

start: ## Start docker containers
	${COMPOSE_FILE} start

restart: ## Restart docker containers
	${COMPOSE_FILE} restart

remove: ## Remove docker containers
	${COMPOSE_FILE} rm -f --stop

shell: ## Run container shell
	${DOCKER_EXEC} sh

install: ## Install dependencies
	${DOCKER_EXEC} composer install

install-tools:
	${DOCKER_EXEC} composer install:tools

migrate: ## Run database migrations
	${DOCKER_EXEC} bin/console doctrine:migrations:migrate --no-interaction

cs-fix: ## Apply coding standards
	${DOCKER_EXEC} composer cs:fix

test: ## Run tests
	${DOCKER_EXEC} composer test

analyze: ## Run static analyze
	${DOCKER_EXEC} composer analyze

logs: ## Show container logs
	${COMPOSE_FILE} --profile ${APP_PROFILE} logs -f

.PHONY: help setup rebuild stop start restart remove shell install install-tools migrate cs-fix test analyze logs
