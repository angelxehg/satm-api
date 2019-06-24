CREATE DATABASE laravel DEFAULT CHARACTER SET utf8;
CREATE USER laravel_admin@localhost IDENTIFIED BY "laravel";
GRANT ALL ON laravel.* TO laravel_admin@localhost IDENTIFIED BY "laravel";