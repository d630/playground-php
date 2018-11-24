--
-- CUSTOMER.
--

DELIMITER ;;

CREATE TRIGGER after_delete_customer
AFTER DELETE ON customer
FOR EACH ROW
BEGIN
    UPDATE logi
    SET id = (
        SELECT id
        FROM customer
        ORDER BY id DESC
        LIMIT 1
    )
    WHERE ttable = 'customer';
END;;

CREATE TRIGGER after_insert_customer
AFTER INSERT ON customer
FOR EACH ROW
BEGIN
    UPDATE logi
    SET id = NEW.id
    WHERE ttable = 'customer';

    UPDATE employee
    SET last_customer_id = NEW.id
    WHERE id = NEW.employee_id;
END;;

CREATE TRIGGER after_update_customer
AFTER UPDATE ON customer
FOR EACH ROW
BEGIN
    UPDATE logi
    SET id = NEW.id
    WHERE ttable = 'customer';
END;;

CREATE TRIGGER before_insert_customer
BEFORE INSERT ON customer
FOR EACH ROW
BEGIN
    IF new.rev IS NULL THEN
        SET new.rev = UNIX_TIMESTAMP();
    END IF;
END;;

CREATE TRIGGER before_update_customer
BEFORE UPDATE ON customer
FOR EACH ROW
BEGIN
    SET new.rev = UNIX_TIMESTAMP();
END;;

DELIMITER ;
