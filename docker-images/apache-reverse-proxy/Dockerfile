FROM php:5.6-apache

COPY conf/ /etc/apache2

# Activation des modules
RUN a2enmod proxy proxy_http

# Activation des virtual hosts
RUN a2ensite 000-* 001-*