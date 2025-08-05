FROM php:8.2-apache

# 必要な拡張モジュールをインストール
RUN apt-get update && apt-get install -y \
    zip unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql zip

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ApacheのDocumentRootをLaravelのpublicに変更
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
WORKDIR /var/www/html
RUN a2enmod rewrite
