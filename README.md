# HTTP Infrastructure Lab - Documentation

## Step 1 : Apache httpd server with Docker, static content

Folder : `/docker-images/apache-php-image`

### Application

In this first step, we implemented an Apache httpd server with static content. Its content is a simple nice looking index website page from a template found on the Internet.

### Specification

For our server, we used an existing image from the docker hub as a base : `php:5.6-apache`

As the server is implemented to be executed with Docker, its IP address is the one of the Docker Virtual Machine : 192.168.99.100 and accepts connection on port 80 (the default port number to consult an HTTP server via a web browser).

The template used for this lab is a very simple one found in Bootstrap free themes online database :

https://startbootstrap.com/themes/one-page-wonder/

The configuration files are located in `/etc/apache2/` inside the running container.

### First step demo

First, we have to build our Docker image. The Dockerfile is located in `docker-images/apache-php-images/`. To build the image, type the following command :

`docker build -t res/apache_php .`

Then, we have to run the container with port-mapping :

`docker run -p 9090:80 res/apache_php`

Finally, we can access the content from a browser by typing this into our favorite web browser (Firefox was used here) :
`192.168.99.100:9090`. It will automatically open the `index.html` file located in the `content` folder.

### About the Dockerfile

The command `FROM` is used to take a base image, here this image is the official one of an Apache HTTP server with PHP.

The command `COPY` is used to copy the content of the `content` directory in the `/var/www/html` directory inside the docker container that will be built. With this instruction, we respect the files hierarchy in the Apache server container.

## Step 2 : Dynamic HTTP server with express.js

Folder : `/docker-images/express-image`

### Application

In this second step, we implemented a server with dynamic content. The server sends very renowed poem with 3 verses of 12 to 18 words in the "Bubu" extraterrestrial language. The poetry you will get is the key to the infinite happiness (but can you translate it ?)

### Specification

The server's IP address is the same as in the first step. This time, we have 3000 as port number.

We decided to use express.js framework to send the sentences in JSON representation data. The sentences are randomly generated with the chance javascript module (to be honest, it is not the Bubu language but a sentence composed with random semi-pronounceable nonsense words).

### Second step demo

First, we have to build our Docker image. The Dockerfile is located in `docker-images/express-image/`. To build the image, type the following command :

`docker build -t res/bubu .`

Then, we have to run the container with port-mapping :

`docker run -p 9090:3000 res/bubu`

Finally, we can access the content from a browser by typing this into our favorite web browser (Firefox was used here) :
`192.168.99.100:9090`. It will automatically open a JSON representation of the resource asked, in this case the very famous Bubu poem.

## Step 3 : Reverse proxy with apache

### Application

In this third step, we implemented a reverse proxy with Apache (static configuration). Its job is to redirect the client either to the first step's server (the static one) or the second's (the dynamic one), depending on the GET request.

### Specification

We used following base image for our server : `php:5.6-apache` (like in the first step). Its IP address is Docker Machine one, like in the previous steps.

From the base image, we added some content to the `sites-availables` folder (situated in the configuration files of the apache server, like explained in the first step), to give access to our previous applications. 

Inside it, we wrote a default configuration file and one for our reverse proxy.

/!\ Be careful : inside this second file, the container's IP addresses are hard-coded. You would have to modify them if the addresses of your containers are not the same as ours.

### Third step demo :

Before testing this new server, you have to make sure that you have the 2 previous applications containers running and check if the IP addresses are still effective.

The Dockerfile is located in the `docker-images/apache-reverse-proxy/` folder. To build the image, type :

`docker build -t res/apache_rp .`

To run the container :

`docker run -p 8080:80 res/apache_rp`

Finally, you have to change your DNS configuration to have access to our server via your web browser and add a new entry with the Docker machine IP address with `demo.res.ch`.

Then you can try with your browser either `demo.res.ch:8080` or `demo.res.ch:8080/api/bubu/`.
