--
-- FILE.
--

DELIMITER ;;

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

CREATE TRIGGER before_insert_file
BEFORE INSERT ON file
FOR EACH ROW
BEGIN
    IF new.mtime IS NULL THEN
        SET new.mtime = UNIX_TIMESTAMP();
    END IF;
END;;

CREATE TRIGGER before_update_file
BEFORE UPDATE ON file
FOR EACH ROW
BEGIN
    SET new.mtime = UNIX_TIMESTAMP();
END;;

DELIMITER ;
