#!/bin/bash

docker run -d --name ex_dynamic_2 labo_express_students
docker inspect ex_dynamic_2 | grep -i ipaddress