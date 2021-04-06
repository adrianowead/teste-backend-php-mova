up:
	docker-compose up
down:
	docker-compose down
php:
	docker exec -it tvas-php bash
db:
	docker exec -it tvas-sql bash -c "mysql -u tvas -p'tvas' tvas"
migrate:
	vendor/bin/phinx migrate
log:
	docker exec -it tvas-php bash -c "grc -c conf.log tail -f var/logs/app.log"
install:
	composer install
update:
	composer update
ana:
	vendor/bin/psalm --show-info=true