#!/bin/sh

echo "Aguardando o MySQL iniciar..."

until nc -z -v -w30 mysql 3306
do
  echo "MySQL ainda não está disponível - aguardando..."
  sleep 5
done

echo "MySQL está pronto, iniciando o PHP-FPM..."
exec docker-php-entrypoint php-fpm
