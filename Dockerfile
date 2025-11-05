ARG PHP_VERSION=8.4

# Imagem base
FROM alpine AS base

FROM wordpress:cli-php${PHP_VERSION} AS php

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY bin/install.sh /usr/local/bin/

VOLUME [ "/app" ]
WORKDIR /app

ENTRYPOINT [ "docker-php-entrypoint" ]

# Imagem para o WordPress com PHP-FPM
FROM wordpress:php${PHP_VERSION}-fpm-alpine AS fpm

FROM nginx:stable-alpine AS server

COPY resources/nginx/conf.d /etc/nginx/conf.d

VOLUME [ "/app" ]
WORKDIR /app
