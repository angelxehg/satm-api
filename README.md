# Laravel API

## Instalación

`git clone https://github.com/angelxehg/laravel-api.git`

`cd laravel-api`

`composer install`

`cp .env.example .env`

`php artisan key:generate`

`php artisan jwt:secret`

`mysql -u root < db.sql`

`php artisan migrate:fresh --seed`

## Configuración

### Apache

`sudo nano +164 /etc/apache2/apache2.conf`

Cambiar:
<Directory /var/www/>
Options Indexes FollowSymLinks
AllowOverride All
Require all granted

Ejecutar
`sudo a2enmod rewrite`

`sudo service apache2 restart`