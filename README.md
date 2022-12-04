# About

This repository have the code of vzenix.es

It's writing with Symfony (PHP)

You can launch it with a custom docker image, use this cmd for generte it (it's only a sample)

``` docker build -t "website_vzenix_es" . ```

Note: This image doesn't include the code of website, you need configure it, example with docker-compose

```
services:

  vzenix_es:
    image: website_vzenix_es
    container_name: vzenix_es
    hostname: local.vzenix.es
    port:
        80:80
        443:443
    environment:
      - APP_ENV=dev
    volumes:
      - ./www:/var/www/html # DocumentRoot
      - ./srv_apl/vzenix_es/conf:/etc/apache2/sites-enabled   # VHost
      - ./logs/vzenix_es:/var/log/apache2 # Apache Logs

```


# Acerca de

Este repositorio contiene el código del portal vzenix.es

El código está escrito con Symfony (PHP)

Puedes lanzar esta página con la imagen personalizada de docker, usa este comando para generar la imagen (este comando es solo un ejemplo)

``` docker build -t "website_vzenix_es" . ```

Nota: Esta imagen no incluye el código fuente de la página, tienes que configurar esto, pongo un ejemplo usando docker-compose

```
services:

  vzenix_es:
    image: website_vzenix_es
    container_name: vzenix_es
    hostname: local.vzenix.es
    port:
        80:80
        443:443
    environment:
      - APP_ENV=dev
    volumes:
      - ./www:/var/www/html # DocumentRoot
      - ./srv_apl/vzenix_es/conf:/etc/apache2/sites-enabled   # VHost
      - ./logs/vzenix_es:/var/log/apache2 # Apache Logs

```
