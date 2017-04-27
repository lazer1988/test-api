# API

You should install [composer](https://getcomposer.org/) globally by using this command `sudo apt-get install composer`

After installation run `composer install` to install all dependencies

You need change folders permissions to 777 rights
`/storage/logs`
`/bootstrap/cache`
`/storage/framework/cache`

Create `.env` from `.env.example` and fill with your local parameters.

run `php artisan migrate` to create database tables