# Laravel API

This is a template project to create an REST API, based on Laravel

## New Install Setup

`git clone https://github.com/angelxehg/laravel-api.git`

`cd laravel-api`

`composer install`

`cp .env.example .env`

`php artisan key:generate`

`php artisan jwt:secret`

`mysql -u root < db.sql`

`php artisan migrate:fresh --seed`

## Update Setup

`cd laravel-api`

`git pull`

`composer install`

**Important** Do not include the ":fresh --seed" parameter to conserve data

`php artisan migrate`

## Configuration

### Apache

`sudo nano +164 /etc/apache2/apache2.conf`

Cambiar:
<Directory /var/www/>
Options Indexes FollowSymLinks
AllowOverride All
Require all granted

Run

`sudo a2enmod rewrite`

`sudo service apache2 restart`
