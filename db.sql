CREATE DATABASE laravel_db DEFAULT CHARACTER SET utf8;
CREATE USER laravel_user@localhost IDENTIFIED BY "laravel_pass";
GRANT ALL ON laravel_db.* TO laravel_user@localhost IDENTIFIED BY "laravel_pass";