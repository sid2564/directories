FROM php:8.1-apache

# mysqli install karo
RUN docker-php-ext-install mysqli

COPY . /var/www/html/

EXPOSE 80
