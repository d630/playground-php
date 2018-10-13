SET NAMES 'utf8mb4';

DELIMITER ;

START TRANSACTION;

DROP DATABASE IF EXISTS corg;
CREATE DATABASE corg;
USE corg;

SOURCE tables.sql;
SOURCE triggers.sql;
SOURCE routines.sql;
SOURCE data.sql;

COMMIT;
