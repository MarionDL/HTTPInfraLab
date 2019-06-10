#!/bin/bash

docker run -d --name ap_static labo_apache_php 
docker inspect ap_static | grep -i ipaddress