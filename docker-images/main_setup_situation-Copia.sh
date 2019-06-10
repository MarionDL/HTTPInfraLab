#!/bin/bash

docker stop $(docker ps -aq)
docker rm $(docker ps -aq)

echo "------------- dynamic 1 ---------------"

cd express-image
./build-image.sh
./run-container-name.sh

echo "------------- static 1 ---------------"

cd ../apache-php-image
./build-image.sh
./run-container-name.sh

echo "------------- dynamic 2 ---------------"

cd ../express-image
./build-image.sh
./run-container-name2.sh

echo "------------- static 2 ---------------"

cd ../apache-php-image
./build-image.sh
./run-container-name2.sh