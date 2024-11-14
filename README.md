# How to start project

## lab1

`docker-compose up --build -d`

`docker exec php sh -c "composer install"`

http://localhost:8000/ - Nginx

http://localhost:8000/node/ - Express.js

http://localhost:8000/php/ - Laravel

http://localhost:8000/python/ - FastAPI

`docker-compose down` - to stop project

## lab2-3 (one project)

Start docker-compose: `docker-compose up --build`

Stop: `docker-compose down`

### lab2

Adminer for node project:

Engine: `PostgreeSQL`

Name: `pg`

User: `pguser`

Password: `password`

http://localhost:3000/api - Swagger

http://localhost:3000/products - all products

http://localhost:3000/categories - all categories

### lab3

Adminer for php project:

Engine: `PostgreeSQL`

Name: `pg`

User: `pguser`

Password: `password`

http://localhost:8081/php/swagger - Swagger UI for PHP Laravel

http://localhost:8081/php/swagger-docs - Swagger docs

http://localhost:8081/php/api/subscribers - all subscribers

http://localhost:8081/php/api/subscriptions - all subscriptions


