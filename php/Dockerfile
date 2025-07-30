FROM php:8.1-fpm

RUN apt-get update \
  && apt-get install -y netcat-traditional \
  && docker-php-ext-install pdo pdo_mysql

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"a]

