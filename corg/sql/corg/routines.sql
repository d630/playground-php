--
-- STORED PROCS AND FUNCS
--

DELIMITER ;;

-- GETTERS.

-- See: https://stackoverflow.com/questions/16519648/sql-for-ordering-by-number-1-2-3-4-etc-instead-of-1-10-11-12

CREATE PROCEDURE get_all_customers_tiny_flip
()
BEGIN
    SELECT org, id
    FROM customer;
END;;

CREATE PROCEDURE get_all_customers_tiny
()
BEGIN
    SELECT id, org
    FROM customer
    ORDER BY LENGTH(org) ASC, org ASC;
END;;

CREATE PROCEDURE get_all_customers_short
()
BEGIN
    SELECT id, org, rev
    FROM customer
    ORDER BY rev DESC, LENGTH(org) ASC, org ASC;
END;;

CREATE PROCEDURE get_customer
(IN _id INT UNSIGNED)
BEGIN
    SELECT customer.id,
        customer.family_name,
        customer.given_name,
        customer.additional_name,
        customer.honorific_prefix,
        customer.honorific_suffix,
        customer.role,
        customer.org,
        customer.post_office_box,
        customer.street_address,
        customer.extended_address,
        customer.locality,
        customer.region,
        customer.postal_code,
        customer.country_name,
        customer.tel,
        customer.email,
        customer.url,
        customer.rev,
        employee.id AS employee_id,
        employee.nickname
    FROM customer, employee
    WHERE customer.id = _id
        AND customer.employee_id = employee.id;
END;;

CREATE PROCEDURE get_associations
(IN _id INT UNSIGNED)
BEGIN
    SELECT customer.id, customer.org
    FROM association, customer
    WHERE association.customer_id_1 = customer.id
        AND association.customer_id_2 = _id
    UNION
    SELECT customer.id, customer.org
    FROM association, customer
    WHERE association.customer_id_2 = customer.id
        AND association.customer_id_1 = _id
    ORDER BY LENGTH(org) ASC, org ASC;
END;;

CREATE PROCEDURE get_associations_tiny
(IN _id INT UNSIGNED)
BEGIN
    SELECT customer_id_1
    FROM association
    WHERE customer_id_2 = _id
    UNION
    SELECT customer_id_2
    FROM association
    WHERE customer_id_1 = _id;
END;;

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

CREATE PROCEDURE get_all_activities_tiny
()
BEGIN
    SELECT id
    FROM activity
    ORDER BY id DESC;
END;;

CREATE PROCEDURE get_all_activities_short
()
BEGIN
    SELECT activity.id, activity.mtime, customer.org, activity.name
    FROM customer, activity
    WHERE customer.id = activity.customer_id
    ORDER BY activity.mtime DESC;
END;;

CREATE PROCEDURE get_activities
(IN _id INT UNSIGNED)
BEGIN
    SELECT activity.id, activity.mtime, activity.name, activity.description
    FROM customer, activity
    WHERE customer.id = _id
        AND customer.id = activity.customer_id
    ORDER BY activity.mtime DESC;
END;;

CREATE PROCEDURE get_activity
(IN _id INT UNSIGNED)
BEGIN
    SELECT activity.id,
        activity.mtime,
        activity.name,
        activity.description,
        customer.org,
        customer.id AS customer_id,
        employee.nickname,
        employee.id AS employee_id
    FROM activity, employee, customer
    WHERE activity.id = _id
        AND activity.customer_id = customer.id
        AND activity.employee_id = employee.id;
END;;

CREATE PROCEDURE get_all_files_tiny
()
BEGIN
    SELECT id
    FROM file
    ORDER BY id DESC;
END;;

CREATE PROCEDURE get_all_files_short
()
BEGIN
    SELECT file.id, file.mtime, file.name, activity.name AS activity_name
    FROM reference, file, activity
    WHERE reference.file_id = file.id
        AND reference.activity_id = activity.id
    ORDER BY file.mtime DESC, activity_name ASC, file.name ASC;
END;;

CREATE PROCEDURE get_files
(IN _id INT UNSIGNED)
BEGIN
    SELECT file.id, file.mtime, file.size, file.name
    FROM activity, reference, file
    WHERE activity.id = _id
        AND reference.activity_id = activity.id
        AND reference.file_id = file.id
    ORDER BY file.mtime DESC;
END;;

CREATE PROCEDURE get_file
(IN _id INT UNSIGNED)
BEGIN
    SELECT file.id,
        file.mtime,
        file.size,
        file.mtype,
        file.name,
        file.description,
        activity.id AS activity_id,
        activity.name AS activity_name,
        customer.id AS customer_id,
        customer.org AS org
    FROM file, customer, activity, reference
    WHERE file.id = _id
        AND file.id = reference.file_id
        AND activity.id = reference.activity_id
        AND customer.id = activity.customer_id;
END;;

CREATE PROCEDURE get_references
(IN _id INTEGER UNSIGNED)
BEGIN
    SELECT activity_id
    FROM reference
    WHERE file_id = _id;
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

CREATE PROCEDURE get_last_customer_id
()
BEGIN
    SELECT id
    FROM logi
    WHERE ttable = 'customer';
END;;

CREATE PROCEDURE get_last_activity_id
()
BEGIN
    SELECT id
    FROM logi
    WHERE ttable = 'activity';
END;;

CREATE PROCEDURE get_last_file_id
()
BEGIN
    SELECT id
    FROM logi
    WHERE ttable = 'file';
END;;

CREATE PROCEDURE get_employee
(IN _nickname VARCHAR(80))
BEGIN
    SELECT *
    FROM employee
    WHERE nickname = _nickname;
END;;

CREATE PROCEDURE is_nickname
(IN _nickname VARCHAR(80))
BEGIN
    SELECT 1
    FROM employee
    WHERE nickname = _nickname;
END;;

-- SETTERS

CREATE FUNCTION is_dup_association
(_id1 INTEGER UNSIGNED, _id2 INTEGER UNSIGNED)
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    return (
        SELECT
            CASE
                WHEN COUNT(*) > 0
                THEN TRUE
                ELSE FALSE
            END
        FROM association
        WHERE customer_id_1 = _id2
            AND customer_id_2 = _id1
    );
END;;

CREATE FUNCTION is_self_association
(_id1 INTEGER UNSIGNED, _id2 INTEGER UNSIGNED)
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    return (SELECT _id1 = _id2);
END;;

CREATE PROCEDURE check_association
(_id1 INTEGER UNSIGNED, _id2 INTEGER UNSIGNED)
BEGIN
    IF is_self_association(_id1, _id2)
        OR is_dup_association(_id1, _id2)
    THEN
        SET @msg = CONCAT('Duplicate or self entry: ', _id1, '-', _id2);
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = @msg, MYSQL_ERRNO = 1001;
    END IF;
END;;

CREATE PROCEDURE set_customer
(IN _family_name VARCHAR(80),
    _given_name VARCHAR(80),
    _additional_name VARCHAR(80),
    _honorific_prefix VARCHAR(80),
    _honorific_suffix VARCHAR(80),
    _role VARCHAR(80),
    _org VARCHAR(80),
    _post_office_box VARCHAR(80),
    _street_address VARCHAR(80),
    _extended_address VARCHAR(80),
    _locality VARCHAR(80),
    _region VARCHAR(80),
    _postal_code VARCHAR(80),
    _country_name VARCHAR(80),
    _tel VARCHAR(80),
    _email VARCHAR(80),
    _url VARCHAR(80),
    _employee_id INT UNSIGNED)
BEGIN
    INSERT INTO customer(
        family_name,
        given_name,
        additional_name,
        honorific_prefix,
        honorific_suffix,
        role,
        org,
        post_office_box,
        street_address,
        extended_address,
        locality,
        region,
        postal_code,
        country_name,
        tel,
        email,
        url,
        employee_id)
    VALUES(_family_name,
        _given_name,
        _additional_name,
        _honorific_prefix,
        _honorific_suffix,
        _role,
        _org,
        _post_office_box,
        _street_address,
        _extended_address,
        _locality,
        _region,
        _postal_code,
        _country_name,
        _tel,
        _email,
        _url,
        _employee_id);
END;;

CREATE PROCEDURE set_association
(IN _customer_id_1 INT UNSIGNED, _customer_id_2 INT UNSIGNED)
BEGIN
    INSERT INTO association
    VALUES (_customer_id_1, _customer_id_2);
END;;

CREATE PROCEDURE set_activity
(IN _name VARCHAR(80), _description TEXT, _customer_id INT UNSIGNED,
    _employee_id INT UNSIGNED)
BEGIN
    INSERT INTO activity(name, description, customer_id, employee_id)
    VALUES (_name, _description, _customer_id, _employee_id);
END;;

CREATE PROCEDURE set_file
(IN _size BIGINT UNSIGNED, _mtype VARCHAR(80), _name VARCHAR(80),
    _description TEXT)
BEGIN
    INSERT INTO file(size, mtype, name, description)
    VALUES (_size, _mtype, _name, _description);
END;;

CREATE PROCEDURE set_reference
(IN _activity_id INT UNSIGNED, _file_id INT UNSIGNED)
BEGIN
    INSERT INTO reference
    VALUES (_activity_id, _file_id);
END;;

CREATE PROCEDURE set_employee
(IN _nickname VARCHAR(80), _password VARCHAR(255))
BEGIN
    INSERT INTO employee
    VALUES (null, _nickname, _password);
END;;

-- UNSETTERS.

CREATE PROCEDURE unset_customer
(IN _id INTEGER UNSIGNED)
BEGIN
    DELETE
    FROM customer
    WHERE id = _id;
END;;

CREATE PROCEDURE unset_activity
(IN _id INTEGER UNSIGNED)
BEGIN
    DELETE
    FROM activity
    WHERE id = _id;
END;;

CREATE PROCEDURE unset_association
(IN _customer_id_1 INTEGER UNSIGNED, _customer_id_2 INTEGER UNSIGNED)
BEGIN
    DELETE
    FROM association
    WHERE (
        customer_id_1 = _customer_id_1
        AND customer_id_2 = _customer_id_2
    ) OR (
        customer_id_1 = _customer_id_2
        AND customer_id_2 = _customer_id_1
    );
END;;

CREATE PROCEDURE unset_file
(IN _id INTEGER UNSIGNED)
BEGIN
    DELETE
    FROM file
    WHERE id = _id;
END;;

CREATE PROCEDURE unset_orphans
()
BEGIN
    DELETE
    FROM file
    WHERE id NOT IN (
        SELECT file_id
        FROM reference
    );
END;;

CREATE PROCEDURE unset_reference
(IN _activity_id INTEGER UNSIGNED, IN _file_id INTEGER UNSIGNED)
BEGIN
    DELETE
    FROM reference
    WHERE activity_id = _activity_id
        AND file_id = _file_id;
END;;

-- RESETTERS.

CREATE PROCEDURE reset_customer
(IN _family_name VARCHAR(80),
     _given_name VARCHAR(80),
     _additional_name VARCHAR(80),
     _honorific_prefix VARCHAR(80),
     _honorific_suffix VARCHAR(80),
     _role VARCHAR(80),
     _post_office_box VARCHAR(80),
     _street_address VARCHAR(80),
     _extended_address VARCHAR(80),
     _locality VARCHAR(80),
     _region VARCHAR(80),
     _postal_code VARCHAR(80),
     _country_name VARCHAR(80),
     _tel VARCHAR(80),
     _email VARCHAR(80),
     _url VARCHAR(80))
BEGIN
    UPDATE customer
    SET family_name = _family_name,
        given_name = _given_name,
        additional_name = _additional_name,
        honorific_prefix = _honorific_prefix,
        honorific_suffix = _honorific_suffix,
        role = _role,
        post_office_box = _post_office_box,
        street_address = _street_address,
        extended_address = _extended_address,
        locality = _locality,
        region = _region,
        postal_code = _postal_code,
        country_name = _country_name,
        tel = _tel,
        email = _email,
        url = _url;
END;;

DELIMITER ;
