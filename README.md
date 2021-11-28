## The project guide how to run framework-x.org PHP

## Install project

```bash

# docker up
composer-compose up -d

# install dependences
docker exec -ti php bash
composer install

# create database
docker-compose -ti mysql bash

mysql -u root -p 123456
create database demo;

# go to website

http://localhost/

```