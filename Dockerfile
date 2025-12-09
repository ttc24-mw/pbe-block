FROM php:8.2-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

WORKDIR /var/www/html

COPY backend/ /var/www/html/backend
COPY frontend/ /var/www/html/frontend

# COPY src/index.php /var/www/html/index.php

RUN a2enmod rewrite

EXPOSE 80

CMD ["apache2-foreground"]