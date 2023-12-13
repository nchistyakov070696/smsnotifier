#!/bin/sh

crond -L /dev/stdout

su apache -c 'php bin/console doctrine:migrations:migrate'
su apache -c 'php bin/console doctrine:fixtures:load'

httpd -DFOREGROUND

#su apache -c 'php bin/console messenger:consume async'
