
  

# Tiki PROJECT

  

It's called Tiki, and it's an online bus ticket booking service

  
  

# How you setup and run this project -

  

> step 1: clone repo

  

https://github.com/sayful1411/tiki.git

  

> step 2: go to tiki

  

```bash

cd tiki

```

> step 3: edit .env.example to .env

> step 4: run composer install

  

```bash

composer install

```

> step 5: generate a new key

```bash

php artisan key:generate

```

>  **Important** I used SQLite database. So you don't need to setup a database connection. Just create a database in ***database/database.sqlite*** or when run migrate command it will ask to create database 


> step 6: run migration


```bash

php artisan migrate --seed

```

> step 7: run project

```bash

php artisan serve

```
