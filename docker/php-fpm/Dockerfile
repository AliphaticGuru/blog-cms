# ---------------------
# Stage 1: Builder (Debian)
# ---------------------
FROM debian:stable-slim AS builder

USER root

# Install PHP extension installer
# COPY --from=ghcr.io/mlocati/php-extension-installer:latest \
#      /usr/bin/install-php-extensions /usr/local/bin/install-php-extensions

# Build deps + extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    git curl unzip zip gnupg ca-certificates \
#  && install-php-extensions \
#     pdo_pgsql mbstring zip intl gd \
 && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2.8.12 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html


# ---------------------
# Stage 2: Runtime (Alpine)
# ---------------------
FROM php:8.4-fpm-alpine AS runtime

USER root

# Copy tools from builder
# COPY --from=builder /usr/local/bin/install-php-extensions /usr/local/bin/

# Install PHP extensions natively on Alpine (don’t copy from Debian!)

RUN apk add \
    bash curl unzip zip icu-dev libpng-dev oniguruma-dev libjpeg-turbo-dev libwebp-dev freetype-dev postgresql-dev build-base \
 && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
 && docker-php-ext-install -j$(nproc) pdo_pgsql mbstring intl gd \
 && apk del build-base

# RUN apk add --no-cache \
#     curl unzip zip bash icu-dev libpng-dev oniguruma-dev \
#  && docker-php-ext-install pdo_pgsql mbstring intl gd

COPY --from=builder /usr/bin/composer /usr/bin/composer

# Install runtime deps
# RUN apk add --no-cache curl unzip zip bash \
#  && install-php-extensions \
#     pdo_pgsql mbstring zip intl gd

# PHP configs
COPY 99-custom.ini /usr/local/etc/php/conf.d/
COPY zz-dynamic.conf /usr/local/etc/php-fpm.d/

WORKDIR /var/www/html

# Permissions
RUN chown -R www-data:www-data /var/www/html
USER www-data

CMD ["php-fpm"]








# # Stage 1: Builder
# # FROM ghcr.io/serversideup/php:8.4-fpm AS builder
# FROM php:8.4-fpm-alpine AS builder

# USER root

# # Install PHP extension installer
# COPY --from=ghcr.io/mlocati/php-extension-installer:latest \
#      /usr/bin/install-php-extensions /usr/local/bin/install-php-extensions
# # RUN chmod +x /usr/local/bin/install-php-extensions

# # Install build dependencies + PHP extensions
# RUN apt-get update && apt-get install -y --no-install-recommends \
#     git curl unzip zip gnupg \
#  && install-php-extensions \
#     pdo_pgsql mbstring zip intl gd \
#  && rm -rf /var/lib/apt/lists/*

# USER www-data
 
# # Install Composer
# COPY --from=composer:2.8.12 /usr/bin/composer /usr/bin/composer

# WORKDIR /var/www/html


# # Stage 2: Runtime
# # FROM ghcr.io/serversideup/php:8.4-fpm AS runtime
# FROM php:8.4-fpm-alpine AS runtime

# USER root

# COPY --from=builder /usr/local/bin/install-php-extensions /usr/local/bin/install-php-extensions
# # RUN chmod +x /usr/local/bin/install-php-extensions

# COPY --from=builder /usr/bin/composer /usr/bin/composer

# RUN apt-get update && apt-get install -y --no-install-recommends \
#     curl unzip zip \
#  && install-php-extensions \
#     pdo_pgsql mbstring zip intl gd \
#  && rm -rf /var/lib/apt/lists/*

# USER www-data

# WORKDIR /var/www/html

# COPY 99-custom.ini /usr/local/etc/php/conf.d/
# COPY zz-dynamic.conf /usr/local/etc/php-fpm.d/

# RUN chown -R www-data:www-data /var/www/html
# USER www-data

# CMD ["php-fpm"]