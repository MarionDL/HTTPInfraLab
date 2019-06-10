#!/bin/bash

docker run -d --name ex_dynamic labo_express_students
docker inspect ex_dynamic | grep -i ipaddress