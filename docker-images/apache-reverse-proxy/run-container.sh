#!/bin/bash

docker run -e STATIC_APP1=172.17.0.3:80 -e DYNAMIC_APP1=172.17.0.4:3000 -e STATIC_APP2=172.17.0.5:80 -e DYNAMIC_APP2=172.17.0.2:3000 --name apache_rp -p 8080:80 labo_apache_rp