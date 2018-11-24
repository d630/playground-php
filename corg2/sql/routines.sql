DELIMITER ;

SOURCE routines/activity.sql;
SOURCE routines/association.sql;
SOURCE routines/customer.sql;
SOURCE routines/dashboard.sql;
SOURCE routines/employee.sql;
SOURCE routines/file.sql;
SOURCE routines/reference.sql;

DELIMITER ;;

CREATE PROCEDURE get_able_to_associate_dirty
(IN _id INT UNSIGNED)
BEGIN
    SELECT customer.id, customer.org
    FROM customer
    WHERE customer.id NOT IN (
        SELECT customer_id_1
        FROM association
        WHERE customer_id_2 = _id
        UNION
        SELECT customer_id_2
        FROM association
        WHERE customer_id_1 = _id
    );
END;;

CREATE PROCEDURE get_able_to_reference
(IN _id INTEGER UNSIGNED)
BEGIN
    SELECT activity.id
    FROM activity
    WHERE activity.id NOT IN (
        SELECT activity_id
        FROM reference
        WHERE file_id = _id
   );
END;;

CREATE PROCEDURE get_file_name
(IN _id INTEGER UNSIGNED)
BEGIN
    SELECT name
    FROM file
    WHERE id = _id;
END;;

DELIMITER ;
