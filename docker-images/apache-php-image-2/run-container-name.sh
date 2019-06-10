#!/bin/bash

docker run -d --name ap_static_2 labo_apache_php_2 
docker inspect ap_static_2 | grep -i ipaddress