compose = docker-compose
app-exec = $(compose) exec -it php_app 

up:
	$(compose) kill
	$(compose) build
	$(compose) up -d

stop:
	$(compose) kill

app-ssh:
	$(app-exec) /bin/bash

lint:
	$(app-exec) vendor/bin/php-cs-fixer fix src
