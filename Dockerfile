# pick the image
FROM php:8.1.13-apache

# Identify yourself as the maintainer. Please change to your name and email
LABEL org.opencontainers.image.authors="paco@vzenix.es"

#
# Requirement of composer.phar
#

RUN apt-get update && apt-get install -qq --no-install-recommends \
    libzip-dev \
    zip
RUN apt-get clean all

#
# MariaDB and apache requirements (ssl, headers, mod_rewrite)
#

RUN apt-get update && apt-get install -qq --no-install-recommends \
    openssl\
 && docker-php-ext-install mysqli pdo pdo_mysql opcache sockets zip\
 && a2enmod ssl\
 && a2enmod rewrite\
 && a2enmod headers\
 && apt-get clean all

#
# GD
#

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

CMD ["apache2-foreground"] 
