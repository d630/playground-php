--
-- ACTIVITY.
--

DELIMITER ;;

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

CREATE TRIGGER before_insert_activity
BEFORE INSERT ON activity
FOR EACH ROW
BEGIN
    IF new.mtime IS NULL THEN
        SET new.mtime = UNIX_TIMESTAMP();
    END IF;
END;;

CREATE TRIGGER before_update_activity
BEFORE UPDATE ON activity
FOR EACH ROW
BEGIN
    SET new.mtime = UNIX_TIMESTAMP();
END;;

DELIMITER ;
