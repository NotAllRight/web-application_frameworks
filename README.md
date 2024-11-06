# How to start project

## lab1

`docker-compose up --build -d`

`docker exec php sh -c "composer install"`

http://localhost:8000/ - Nginx

http://localhost:8000/node/ - Express.js

http://localhost:8000/php/ - Laravel

http://localhost:8000/python/ - FastAPI

`docker-compose down` - to stop project

## lab2

Log in to adminer:

Engine: `PostgreeSQL`

Name: `pg`

User: `pguser`

Password: `password`

And execute the sql-query: `CREATE DATABASE nestjs;`

Start docker-compose: `docker-compose up --build`

http://localhost:3000/api - Swagger
http://localhost:3000/products - all products
http://localhost:3000/categories - all categories
http://localhost:8081/docs - Swagger UI for PHP Laravel

`docker-compose down` - to stop project
