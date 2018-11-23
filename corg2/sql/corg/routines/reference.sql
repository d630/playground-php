--
-- REFERENCE
--

DELIMITER ;;

-- GETTERS

CREATE PROCEDURE get_all_references
()
BEGIN
    SELECT *
    FROM reference;
END;;

-- SETTERS

CREATE PROCEDURE set_reference
(IN _activity_id INT UNSIGNED, _file_id INT UNSIGNED)
BEGIN
    INSERT INTO reference
    VALUES (_activity_id, _file_id);
END;;

-- UNSETTERS

CREATE PROCEDURE unset_all_references
()
BEGIN
    DELETE
    FROM reference;
END;;

CREATE PROCEDURE unset_reference
(IN _activity_id INTEGER UNSIGNED, IN _file_id INTEGER UNSIGNED)
BEGIN
    DELETE
    FROM reference
    WHERE activity_id = _activity_id
        AND file_id = _file_id;
END;;

CREATE PROCEDURE unset_all_activities_references
(IN _id INT UNSIGNED)
BEGIN
    DELETE
    FROM reference
    WHERE activity_id = _id;
END;;

CREATE PROCEDURE unset_all_files_references
(IN _id INT UNSIGNED)
BEGIN
    DELETE
    FROM reference
    WHERE file_id = _id;
END;;

-- MISC

DELIMITER ;
