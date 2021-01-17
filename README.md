<p align="center"><a href="https://business.eskimi.com/" target="_blank"><img src="https://business.eskimi.com/wp-content/uploads/2020/03/p6CJ3HHrtGWOOyhO18jUqRkiZFQNtnITLMTa5wqa-1.png" width="400"></a></p>


## About Project

This project is developed for senior full stack PHP developer practical test.

Please click [here](https://drive.google.com/file/d/1LKb73-gQgxSJXL0UJ1oX-n5RF_QK7VYT/view?usp=sharing) for question paper

## Technologies
- PHP
- Laravel
- Mysql
- Docker
- VueJs
## Installation Process
*Docker is available in this project. Please install Docker before start. Click [here](https://www.docker.com/) to know about Docker. For installation guide please follow [this](https://www.docker.com/get-started) link.*
- __Step 1:__ Clone this project `https://github.com/shamimulalam/eskimi.git` form here. Please add `--recurse-submodules` flag while clone. That will pull **laradock**. Laradock is a full PHP development environment for Docker. 
    > git clone --recurse-submodules https://github.com/shamimulalam/eskimi.git
- __Step 2:__ For getting into project directory run  
    > cd eskimi
- __Step 3:__ Now create environment file
    > cp .env.example .env
- __Step 4:__ Now setup database configuration into .env
    > sudo nano .env

        DB_CONNECTION=mysql
        DB_HOST=mysql
        DB_PORT=3306
        DB_DATABASE=eskimi
        DB_USERNAME=root
        DB_PASSWORD=root

  replace DB section with above data. It's highly recommended to create new database user in MySql database with specific database permission and privileges. And use that credential here.
- __Step 5:__ For get into project docker directory run  
    > cd laradock
- __Step 6:__ Create docker environment file by copying env-example file to .env 
    > cp env-example .env
- __Step 7:__ Set same db credential in docker environment file.
    > nano .env
  
        MYSQL_VERSION=latest
        MYSQL_DATABASE=eskimi
        MYSQL_USER=root
        MYSQL_PASSWORD=root
        MYSQL_PORT=33066
        MYSQL_ROOT_PASSWORD=root
        MYSQL_ENTRYPOINT_INITDB=./mysql/docker-entrypoint-initdb.d
- __Step 8:__ Now build docker
    > docker-compose up -d nginx mysql
- __Step 9:__ Login mysql container for creating database
    > docker exec -it laradock_mysql_1 bash
- __Step 10:__ Login mysql console
    > mysql -uroot -proot
- __Step 11:__ Create new database
    > create database eskimi;
- __step 12:__ Exit from mysql console
    > exit
- __Step 13:__ Exit from mysql container
    > exit
- __Step 14:__ Now login into workspace container for application setup
    > docker exec -it laradock_workspace_1 bash
- __Step 15:__ Download laravel dependencies 
    > composer install
- __Step 16:__ Now create environment key for laravel
    > php artisan key:generate
- __Step 17:__ Create soft link with storage folder 
    > php artisan storage:link
- __Step 17:__ Now browse http://localhost/ for application
- __Step 18:__ For system test 
    > php artisan test



## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
