CREATE DATABASE satm_db DEFAULT CHARACTER SET utf8;
CREATE USER satm_db_admin@localhost IDENTIFIED BY "satm_admin";
GRANT ALL ON satm_db.* TO satm_db_admin@localhost IDENTIFIED BY "satm_admin";
