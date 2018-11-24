--
-- FILE
--

DELIMITER ;;

-- GETTERS

CREATE PROCEDURE get_all_activities
()
BEGIN
    SELECT *
    FROM activity
    ORDER BY id DESC;
END;;

CREATE PROCEDURE get_all_activities_tiny
()
BEGIN
    SELECT id, name
    FROM activity
    ORDER BY id ASC;
END;;

CREATE PROCEDURE get_activity
(IN _id INT UNSIGNED)
BEGIN
    SELECT *
    FROM activity
    WHERE activity.id = _id;
END;;

CREATE PROCEDURE get_activity_ext
(IN _id INT UNSIGNED)
BEGIN
    SELECT
        activity.*,
        employee.nickname AS employee_nickname,
        customer.org AS customer_org
    FROM  activity, employee, customer
    WHERE activity.id = _id
        AND activity.employee_id = employee.id
        AND activity.customer_id = customer.id;
END;;

CREATE PROCEDURE get_employees_last_activity_id
(IN _id INT UNSIGNED)
BEGIN
    SELECT last_activity_id
    FROM employee
    WHERE id = _id;
END;;

CREATE PROCEDURE get_last_activity_id
()
BEGIN
    SELECT id
    FROM logi
    WHERE ttable = 'activity';
END;;

CREATE PROCEDURE get_all_customers_activities
(IN _id INT UNSIGNED)
BEGIN
    SELECT *
    FROM activity
    WHERE customer_id = _id
    ORDER BY mtime DESC;
END;;

CREATE PROCEDURE get_all_customers_activities_tiny
(IN _id INT UNSIGNED)
BEGIN
    SELECT id, mtime, name, description
    FROM activity
    WHERE customer_id = _id
    ORDER BY mtime DESC;
END;;

CREATE PROCEDURE get_all_files_activities
(IN _id INT UNSIGNED)
BEGIN
    SELECT activity.*
    FROM reference, activity
    WHERE reference.file_id = _id
        AND reference.activity_id = activity.id
    ORDER BY activity.mtime DESC;
END;;

CREATE PROCEDURE get_all_files_activities_tiny
(IN _id INT UNSIGNED)
BEGIN
    SELECT activity.id, activity.mtime, activity.name, activity.description
    FROM reference, activity
    WHERE reference.file_id = _id
        AND reference.activity_id = activity.id
    ORDER BY activity.mtime DESC;
END;;

-- SETTERS

CREATE PROCEDURE set_activity
(IN _name VARCHAR(80), _description TEXT, _customer_id INT UNSIGNED,
    _employee_id INT UNSIGNED)
BEGIN
    INSERT INTO activity(name, description, customer_id, employee_id)
    VALUES (_name, _description, _customer_id, _employee_id);
END;;

-- UNSETTERS

CREATE PROCEDURE unset_all_activities
()
BEGIN
    DELETE
    FROM activity;
END;;

CREATE PROCEDURE unset_activity
(IN _id INTEGER UNSIGNED)
BEGIN
    DELETE
    FROM activity
    WHERE id = _id;
END;;

CREATE PROCEDURE unset_all_files_activities
(IN _id INT UNSIGNED)
BEGIN
    DELETE
    FROM activity
    WHERE id IN (
        SELECT activity_id
        FROM reference
        WHERE file_id = _id
    );
END;;

CREATE PROCEDURE unset_all_customers_activities
(IN _id INT UNSIGNED)
BEGIN
    DELETE
    FROM activity
    WHERE customer_id = _id;
END;;

DELIMITER ;
