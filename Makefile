init:
	tput setaf 4
	cp .env.example .env
	tput setaf 0

	tput setaf 4
	docker-compose up --build -d
	tput setaf 0

	tput setaf 4
	docker exec internal-php-fpm composer install
	tput setaf 0

	tput setaf 4
	docker exec internal-php-fpm php artisan migrate
	tput setaf 0

	tput setaf 4
	docker exec internal-php-fpm php artisan db:seed
	tput setaf 0

	tput setaf 4
	docker exec internal-php-fpm php artisan queue:work --queue=high,medium,low,default
	tput setaf 0

	tput setaf 2
	echo "Init Ok"
	tput setaf 0
	make update
update:
	tput setaf 4
	docker exec internal-php-fpm composer update
	tput setaf 0

	tput setaf 2;
	echo "Update Ok"

	tput setaf 0
	make config
host:
	tput setaf 4
	sh docker/host.sh addhost $(HOSTNAME)
	tput setaf 0

	make start
start:
	tput setaf 4
	cp .env.example .env
	tput setaf 0

	tput setaf 4
	docker-compose up -d
	tput setaf 0

	tput setaf 5; echo "Start Ok"