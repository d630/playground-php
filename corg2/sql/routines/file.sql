--
-- FILE
--

DELIMITER ;;

-- GETTERS

CREATE PROCEDURE get_all_files
()
BEGIN
    SELECT *
    FROM file
    ORDER BY id DESC;
END;;

CREATE PROCEDURE get_all_files_small
()
BEGIN
    SELECT id, name
    FROM file
    ORDER BY id DESC;
END;;

CREATE PROCEDURE get_all_file_ids
()
BEGIN
    SELECT id
    FROM file
    ORDER BY id DESC;
END;;

CREATE PROCEDURE get_employees_last_file_id
(IN _id INT UNSIGNED)
BEGIN
    SELECT last_file_id
    FROM employee
    WHERE id = _id;
END;;

CREATE PROCEDURE get_file
(IN _id INT UNSIGNED)
BEGIN
    SELECT *
    FROM file
    WHERE file.id = _id;
END;;

CREATE PROCEDURE get_last_file_id
()
BEGIN
    SELECT id
    FROM logi
    WHERE ttable = 'file';
END;;

CREATE PROCEDURE get_orphans
()
BEGIN
    SELECT id
    FROM file
    WHERE id NOT IN (
        SELECT DISTINCT file_id
        FROM reference
    );
END;;

CREATE PROCEDURE get_all_activities_files
(IN _id INT UNSIGNED)
BEGIN
    SELECT file.*
    FROM reference, file
    WHERE reference.activity_id = _id
        AND reference.file_id = file.id
    ORDER BY file.mtime DESC;
END;;

CREATE PROCEDURE get_all_activities_files_small
(IN _id INT UNSIGNED)
BEGIN
    SELECT file.id, file.mtime, file.size, file.name
    FROM reference, file
    WHERE reference.activity_id = _id
        AND reference.file_id = file.id
    ORDER BY file.mtime DESC;
END;;

CREATE PROCEDURE get_all_activities_file_ids
(IN _id INT UNSIGNED)
BEGIN
    SELECT file.id
    FROM reference, file
    WHERE reference.activity_id = _id
        AND reference.file_id = file.id
    ORDER BY file.mtime DESC;
END;;

CREATE PROCEDURE get_all_customers_files
(IN _id INT UNSIGNED)
BEGIN
    SELECT DISTINCT file.*
    FROM activity, reference, file
    WHERE activity.customer_id = _id
        AND reference.activity_id = activity.id
        AND reference.file_id = file.id
    ORDER BY file.mtime DESC;
END;;

CREATE PROCEDURE get_all_customers_files_small
(IN _id INT UNSIGNED)
BEGIN
    SELECT DISTINCT file.id, file.mtime, file.size, file.name
    FROM activity, reference, file
    WHERE activity.customer_id = _id
        AND reference.activity_id = activity.id
        AND reference.file_id = file.id
    ORDER BY file.mtime DESC;
END;;

CREATE PROCEDURE get_all_customers_file_ids
(IN _id INT UNSIGNED)
BEGIN
    SELECT DISTINCT file.id
    FROM activity, reference, file
    WHERE activity.customer_id = _id
        AND reference.activity_id = activity.id
        AND reference.file_id = file.id
    ORDER BY file.mtime DESC;
END;;

-- SETTERS

CREATE PROCEDURE set_file
(IN _size BIGINT UNSIGNED, _mtype VARCHAR(80), _name VARCHAR(80),
    _description TEXT, _employee_id INT UNSIGNED)
BEGIN
    INSERT INTO file(size, mtype, name, description, employee_id)
    VALUES (_size, _mtype, _name, _description, _employee_id);
END;;

-- UNSETTERS

CREATE PROCEDURE unset_all_files
()
BEGIN
    DELETE
    FROM file;
END;;

CREATE PROCEDURE unset_file
(IN _id INTEGER UNSIGNED)
BEGIN
    DELETE
    FROM file
    WHERE id = _id;
END;;

CREATE PROCEDURE unset_all_activities_files
(IN _id INT UNSIGNED)
BEGIN
    DELETE
    FROM file
    WHERE id IN (
        SELECT file_id
        FROM reference
        WHERE activity_id = _id
    );
END;;

CREATE PROCEDURE unset_all_customers_files
(IN _id INT UNSIGNED)
BEGIN
    DELETE
    FROM file
    WHERE id IN (
        SELECT DISTINCT reference.file_id
        FROM activity, reference
        WHERE activity.customer_id = _id
            AND reference.activity_id = activity.id
    );
END;;

CREATE PROCEDURE unset_orphans
()
BEGIN
    DELETE
    FROM file
    WHERE id NOT IN (
        SELECT DISTINCT file_id
        FROM reference
    );
END;;

-- MISC

DELIMITER ;
