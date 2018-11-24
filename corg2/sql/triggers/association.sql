--
-- ASSOCIATION.
--

DELIMITER ;;

CREATE TRIGGER before_insert_association
BEFORE INSERT ON association
FOR EACH ROW
BEGIN
    CALL check_association_pair(NEW.customer_id_1, NEW.customer_id_2);
END;;

CREATE TRIGGER before_update_association
BEFORE UPDATE ON association
FOR EACH ROW
BEGIN
    CALL check_association_pair(NEW.customer_id_1, NEW.customer_id_2);
END;;

DELIMITER ;
