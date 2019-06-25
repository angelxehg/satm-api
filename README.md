# satm-api
API para el Sistema de Administración de Tareas de Mantenimiento

# Instalación
`git clone https://github.com/peranghx/satm-api`

`cd satm-api`

`composer install`

`cp .env.production .env`, o en entornos de prueba `cp .env.example .env`

`php artisan key:generate`

`php artisan jwt:secret`

`mysql -u root < db.sql`

`php artisan migrate:fresh --seed`

# Configuración

## Apache
`sudo nano +164 /etc/apache2/apache2.conf`

Cambiar:
<Directory /var/www/>
Options Indexes FollowSymLinks
AllowOverride All
Require all granted

Ejecutar
`sudo a2enmod rewrite`

`sudo service apache2 restart`

## Usuario Administrador
Inicie sesión (con satm-web), y cambie el email y contraseña. Por defecto:
Correo: `admin@utzac.edu.mx`
Contraseña: `admin`