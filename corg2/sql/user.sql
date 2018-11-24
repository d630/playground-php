DELIMITER ;

CREATE USER 'corg'@'localhost' IDENTIFIED BY 'password';
GRANT ALL ON corg.* TO 'corg'@'localhost';
FLUSH PRIVILEGES;
