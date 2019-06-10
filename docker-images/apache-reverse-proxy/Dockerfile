FROM php:5.6-apache

#RUN apt-get update && apt-get install -y vim && apt-get install -y nano

COPY conf/ /etc/apache2

COPY apache2-foreground /usr/local/bin/
COPY templates /var/apache2/templates


# Activation des modules (on ajoute le lbmethod_byrequests et les headers pour les cookies)
RUN a2enmod proxy proxy_http proxy_balancer lbmethod_byrequests headers

# Activation des virtual hosts
RUN a2ensite 000-* 001-*

# necessaire pour faire marcher les headers
RUN service apache2 restart