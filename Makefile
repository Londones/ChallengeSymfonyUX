compose = docker-compose
app-exec = $(compose) exec php

up:
	$(compose) kill
	$(compose) build
	$(compose) up -d

stop:
	$(compose) kill

app-exec:
	$(app-exec) $(CMD)

app-ssh:
	$(app-exec) /bin/bash

lint:
	$(app-exec) vendor/bin/php-cs-fixer fix src
