--
-- EMPLOYEE
--

DELIMITER ;;

-- GETTERS

CREATE PROCEDURE get_employee
(IN _nickname VARCHAR(80))
BEGIN
    SELECT *
    FROM employee
    WHERE nickname = _nickname;
END;;

-- SETTERS

CREATE PROCEDURE set_employee
(IN _nickname VARCHAR(80), _password VARCHAR(255))
BEGIN
    INSERT INTO employee(nickname, password)
    VALUES (_nickname, _password);
END;;

DELIMITER ;
