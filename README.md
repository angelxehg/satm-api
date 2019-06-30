# Laravel API

This is a template project to create an REST API, based on Laravel

## Setup

`git clone https://github.com/angelxehg/laravel-api.git`

`cd laravel-api`

`composer install`

`cp .env.example .env`

`php artisan key:generate`

`php artisan jwt:secret`

`mysql -u root < db.sql`

`php artisan migrate:fresh --seed`

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