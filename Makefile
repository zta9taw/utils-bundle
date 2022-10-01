include .env

RED=\033[0;31m
NC=\033[0m
GREEN=\033[0;32m
BLUE=\033[2;36m

build:
	docker-compose build

start:
	docker-compose up -d --remove-orphans

restart:
	docker-compose restart

down:
	docker-compose down

stop:
	docker-compose stop

ps:
	docker-compose ps

logs:
	docker-compose logs -f

sh:
	docker exec -it -u `id -u ${USER}` utils_bundle_php /bin/sh

phpcs:
	@echo "$(RED)> Running PHPCS analysis ...$(NC)"
	docker-compose run --rm php bin/phpcs -n --colors --error-severity=1

phpcbf:
	@echo "$(RED)> Running PHPCBF : fixing code style ...$(NC)"
	docker-compose run --rm php bin/phpcbf

test:
	@echo "$(RED)> Running tests ...$(NC)"
	docker-compose run --rm php bin/simple-phpunit

install:
	@echo "$(RED)> Running Composer Install ...$(NC)"
	docker-compose run --rm php composer install

update:
	@echo "$(RED)> Running Composer Update ...$(NC)"
	docker-compose run --rm php composer update

validate:
	@echo "$(RED)> Running Composer Validate ...$(NC)"
	docker-compose run --rm php composer validate
