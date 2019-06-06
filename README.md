# HTTP Infrastructure Lab - Documentation

## Step 1 : Apache httpd server with Docker, static content

### Specification

As the server is implemented to be executed with Docker, its IP address is the one of the Docker Virtual Machine : 192.168.99.100 and the choosen port is 9090.

The template used for this lab is a very simple one found in Bootstrap free themes online database :

https://startbootstrap.com/themes/one-page-wonder/

The configuration files are located in `/etc/apache2/` inside the running container.

### First step demo

First, we have to build our Docker image. The Dockerfile is located in `docker/images/apache-php-images/`. To build the image, type the following command :

`docker build -t res/apache_php .`

Then, we have to run the container :

`docker run -p 9090:80 res/apache_php`

Finally, we can access the content from a browser by typing this into our favorite web browser (Firefox was used here) :
`192.168.99.100:9090`. It will automatically open the `index.html` file located in the `content` folder.

### About the Dockerfile

The command `FROM` is used to take a base image, here this image is the official one of an Apache HTTP server with PHP.

The command `COPY` is used to copy the content of the `content` directory in the `/var/www/html` directory inside the docker container that will be built. With this instruction, we respect the files hierarchy in the Apache server container.
