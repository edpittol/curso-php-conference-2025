ARG PHP_VERSION=8.4

# Imagem base
FROM alpine AS base

RUN apk update

# Construção das dependências
FROM php:${PHP_VERSION}-alpine AS build-deps

ENV BUILD_DEPS="gettext autoconf build-base gcc linux-headers"

RUN set -ex && \
	apk add --update $BUILD_DEPS

FROM build-deps AS chromium

ENV RUNTIME_DEPS="chromium chromium-chromedriver"

RUN set -ex && \
    apk add $RUNTIME_DEPS

FROM build-deps AS procps

ENV RUNTIME_DEPS="procps"

RUN set -ex && \
	apk add $RUNTIME_DEPS

FROM build-deps AS sqlite3

ENV RUNTIME_DEPS="sqlite"

RUN set -ex && \
	apk add $RUNTIME_DEPS

FROM build-deps AS xdebug

RUN set -ex; \
	# Install Xdebug extension
	pecl install xdebug; \
	docker-php-ext-enable xdebug;

# Install, enable and configure Xdebug
RUN { \
	echo 'xdebug.mode = ${PHP_XDEBUG_MODE}'; \
	echo 'xdebug.start_with_request = yes'; \
	echo 'xdebug.client_host = host.docker.internal'; \
	echo 'xdebug.log = /tmp/xdebug.log'; \
} > /usr/local/etc/php/conf.d/xdebug.ini

FROM wordpress:cli-php${PHP_VERSION} AS php

COPY --from=chromium /etc/alsa/ /etc/alsa/
COPY --from=chromium /etc/chromium/ /etc/chromium/
COPY --from=chromium /etc/fonts/ /etc/fonts/
COPY --from=chromium /etc/gtk-3.0/ /etc/gtk-3.0/
COPY --from=chromium /etc/pkcs11/ /etc/pkcs11/
COPY --from=chromium /etc/pulse/ /etc/pulse/
COPY --from=chromium /etc/vdpau_wrapper.cfg /etc/vdpau_wrapper.cfg
COPY --from=chromium /etc/xdg/ /etc/xdg/
COPY --from=chromium /usr/bin/ /usr/bin/
COPY --from=chromium /usr/lib/ /usr/lib/
COPY --from=chromium /usr/share/ /usr/share/

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY --from=procps /bin/ /bin/
COPY --from=procps /sbin/ /sbin/
COPY --from=procps /usr/bin/ /usr/bin/
COPY --from=procps /usr/lib/ /usr/lib/

COPY --from=sqlite3 /usr/bin/ /usr/bin/

COPY --from=xdebug /usr/local/etc/php/ /usr/local/etc/php/
COPY --from=xdebug /usr/local/lib/php/ /usr/local/lib/php/
COPY --from=xdebug /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

COPY bin/install.sh /usr/local/bin/

VOLUME [ "/app" ]
WORKDIR /app

ENTRYPOINT [ "docker-php-entrypoint" ]

# Imagem para o WordPress com PHP-FPM
FROM wordpress:php${PHP_VERSION}-fpm-alpine AS fpm

COPY --from=xdebug /usr/local/etc/php/ /usr/local/etc/php/
COPY --from=xdebug /usr/local/lib/php/ /usr/local/lib/php/
COPY --from=xdebug /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

FROM nginx:stable-alpine AS server

COPY resources/nginx/conf.d /etc/nginx/conf.d

VOLUME [ "/app" ]
WORKDIR /app
