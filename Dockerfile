FROM php:7.4-apache

RUN apt-get update && apt-get install -y openssl zip unzip gnupg wget vim curl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 80