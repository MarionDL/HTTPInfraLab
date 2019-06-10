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

## Step 4 : AJAX requests with JQuery

### Application

This fourth step was meant to connect our 2 applications to perform a dynamic reload of our webpage with AJAX requests. Now, the first verse of our Bubu poem is printed on the website.

### Specification

From the first step, we just added a new script that performs this reloading inside the `content` folder. From now on, we work with the previous step specification (with the reverse proxy).

### Fourth step demo :

First you will have to re-build our `apache-php-image`, because the content changed a bit. Then, you have to make sure that you have your 3 containers running (the reverse proxy, the dynamic server and the static server).

Finally, you can access the new content with the instruction given in the previous step : `demo.res.ch:8080`

You will be able to see that every 1000 ms, some of the content of the page changes to print a new verse.

## Step 5 : Improvement of the reverse proxy with apache

### Application

For this fifth step, we reviewed our previous implementation of the reverse proxy server. Remember, it had one big drawback : its configuration was static, so we had to make sure of the IP addresses of our running containers and modify the configuration file if our IP addresses were not matching.

Here, we use the -e option in Docker to set the environment variables of our server, and these variables are included in a new php config file named `config-template`. Like so, we won't have to change the config file and we can directly write our IP addresses when we start the container.

### Specification

From the third step, we had to integrate a configuration script based on the existing official `apache2-foreground` script. This script will set the environment variables we wrote using `docker run`.

The remaining specification is still the same as in the previous steps.

### Fifth step demo :

Of course, we have to re-build our image like so :

`docker build -t res/apache_rp .`

Then, you have to start the 2 applications containers and find their IP addresses with the following command :

`docker inspect <name of your container> | grep -i ipaddress`

You can now start your new apache reverse proxy like so :

`docker run -d -e STATIC_APP=<IP of static app>:80 -e DYNAMIC_APP=<IP of dynamic app>:3000 -p 8080:80 res/apache_rp`

Finally, you can see the result in your web browser like in the previous step.

## Additional step 1 : Management UI with Portainer

We found an interesting app available on DockerHub to help you manage your containers. This app called Portainer helps you by providing a nice looking user interface. To install it, you have to run :

`docker volume create portainer_data`

`docker run -d -p 9000:9000 -v /var/run/docker.sock:/var/run/docker.sock -v portainer_data:/data portainer/portainer`

You can then access this UI with your browser at the following address :

`192.168.99.100:9000`

If you want more information about Portainer : https://www.portainer.io/

## Additional step 2 : Support load balancing (multiple server nodes)

In this additional step, we extended the reverse proxy configuration to support load balancing. With this new feature, we can have multiple server nodes, dynamic ones or static ones.

To perform this, we had to change our `config-template` php file and use the features of the `proxy_balancer` module to define our clusters.

Don't forget to re-build the new image. In our implementation, 
