.PHONY: help install build up down restart logs shell test lint analysis migrate fresh seed

# Default target
help: ## Show this help message
	@echo 'Usage: make [target]'
	@echo ''
	@echo 'Targets:'
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

# Development
install: ## Install dependencies and setup project
	composer install
	npm install
	cp .env.local .env
	php artisan key:generate
	php artisan storage:link
	@echo "Project installed successfully!"

build: ## Build assets
	npm run build

dev: ## Start development server
	npm run dev

# Docker commands
up: ## Start all Docker services
	docker-compose up -d

down: ## Stop all Docker services
	docker-compose down

restart: ## Restart Docker services
	docker-compose restart

logs: ## View Docker logs
	docker-compose logs -f

shell: ## Access app container shell
	docker-compose exec app bash

mysql: ## Access MySQL container
	docker-compose exec mysql mysql -u tracer_user -p tracer_study

redis: ## Access Redis container
	docker-compose exec redis redis-cli

# Laravel commands
migrate: ## Run database migrations
	php artisan migrate

fresh: ## Fresh migration with seeding
	php artisan migrate:fresh --seed

seed: ## Run database seeders
	php artisan db:seed

module-migrate: ## Run module migrations
	php artisan module:migrate

# Code Quality
test: ## Run all tests
	php artisan test

test-coverage: ## Run tests with coverage
	php artisan test --coverage

lint: ## Run code linting (Pint)
	vendor/bin/pint

lint-test: ## Test code style without fixing
	vendor/bin/pint --test

analysis: ## Run static analysis (PHPStan)
	vendor/bin/phpstan analyse

quality: ## Run all code quality checks
	make lint-test
	make analysis
	make test

# Cache commands
cache: ## Cache config, routes, and views
	php artisan config:cache
	php artisan route:cache
	php artisan view:cache

cache-clear: ## Clear all caches
	php artisan config:clear
	php artisan route:clear
	php artisan view:clear
	php artisan cache:clear

# Production deployment
deploy-staging: ## Deploy to staging
	git pull origin develop
	composer install --no-dev --optimize-autoloader
	npm ci --production
	npm run build
	php artisan migrate --force
	make cache

deploy-production: ## Deploy to production
	git pull origin main
	composer install --no-dev --optimize-autoloader
	npm ci --production
	npm run build
	php artisan migrate --force
	make cache
	php artisan queue:restart
