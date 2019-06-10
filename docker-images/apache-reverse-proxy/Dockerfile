FROM php:5.6-apache

RUN apt-get update && apt-get install -y vim && apt-get install -y nano

COPY apache2-foreground /usr/local/bin/
COPY templates /var/apache2/templates

COPY conf/ /etc/apache2

# Activation des modules
RUN a2enmod proxy proxy_http proxy_balancer lbmethod_byrequests

# Activation des virtual hosts
RUN a2ensite 000-* 001-*
