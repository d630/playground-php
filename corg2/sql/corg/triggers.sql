--
-- TRIGGERS.
--

DELIMITER ;;

CREATE TRIGGER before_insert_association
BEFORE INSERT ON association
FOR EACH ROW
BEGIN
    CALL check_association_pair(NEW.customer_id_1, NEW.customer_id_2);
END;;

CREATE TRIGGER before_update_association
BEFORE INSERT ON association
FOR EACH ROW
BEGIN
    CALL check_association_pair(NEW.customer_id_1, NEW.customer_id_2);
END;;

CREATE TRIGGER after_insert_customer
AFTER INSERT ON customer
FOR EACH ROW
BEGIN
    UPDATE logi
    SET id = NEW.id
    WHERE ttable = 'customer';
END;;

CREATE TRIGGER after_update_customer
AFTER UPDATE ON customer
FOR EACH ROW
BEGIN
    UPDATE logi
    SET id = NEW.id
    WHERE ttable = 'customer';
END;;

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

CREATE TRIGGER after_insert_activity
AFTER INSERT ON activity
FOR EACH ROW
BEGIN
    UPDATE logi
    SET id = NEW.id
    WHERE ttable = 'activity';
END;;

CREATE TRIGGER after_update_activity
AFTER UPDATE ON activity
FOR EACH ROW
BEGIN
    UPDATE logi
    SET id = NEW.id
    WHERE ttable = 'activity';
END;;

CREATE TRIGGER after_delete_activity
AFTER DELETE ON activity
FOR EACH ROW
BEGIN
    UPDATE logi
    SET id = (
        SELECT id
        FROM activity
        ORDER BY id DESC
        LIMIT 1
    )
    WHERE ttable = 'activity';
END;;

CREATE TRIGGER after_insert_file
AFTER INSERT ON file
FOR EACH ROW
BEGIN
    UPDATE logi
    SET id = NEW.id
    WHERE ttable = 'file';
END;;

CREATE TRIGGER after_update_file
AFTER UPDATE ON file
FOR EACH ROW
BEGIN
    UPDATE logi
    SET id = NEW.id
    WHERE ttable = 'file';
END;;

CREATE TRIGGER after_delete_file
AFTER DELETE ON file
FOR EACH ROW
BEGIN
    UPDATE logi
    SET id = (
        SELECT id
        FROM file
        ORDER BY id DESC
        LIMIT 1
    )
    WHERE ttable = 'file';
END;;

DELIMITER ;
