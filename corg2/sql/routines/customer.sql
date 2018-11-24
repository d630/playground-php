--
-- CUSTOMER
--

DELIMITER ;;

-- GETTERS

CREATE PROCEDURE get_all_customers
()
BEGIN
    SELECT *
    FROM customer;
END;;

CREATE PROCEDURE get_all_customers_tiny
()
BEGIN
    SELECT id, org
    FROM customer
    ORDER BY LENGTH(org) ASC, org ASC;
END;;

CREATE PROCEDURE get_customer
(IN _id INT UNSIGNED)
BEGIN
    SELECT customer.*
    FROM customer
    WHERE customer.id = _id;
END;;

CREATE PROCEDURE get_customer_ext
(IN _id INT UNSIGNED)
BEGIN
    SELECT customer.*, employee.nickname AS employee_nickname
    FROM customer, employee
    WHERE customer.id = _id
        AND customer.employee_id = employee.id;
END;;

CREATE PROCEDURE get_last_customer_id
()
BEGIN
    SELECT id
    FROM logi
    WHERE ttable = 'customer';
END;;

CREATE PROCEDURE get_all_files_customers
(IN _id INT UNSIGNED)
BEGIN
    SELECT DISTINCT customer.*
    FROM customer, activity, reference
    WHERE reference.file_id = _id
        AND reference.activity_id = activity.id
        AND activity.customer_id = customer.id
    ORDER BY LENGTH(customer.org) ASC, customer.org ASC;
END;;

CREATE PROCEDURE get_all_files_customers_tiny
(IN _id INT UNSIGNED)
BEGIN
    SELECT DISTINCT customer.id, customer.org
    FROM customer, activity, reference
    WHERE reference.file_id = _id
        AND reference.activity_id = activity.id
        AND activity.customer_id = customer.id
    ORDER BY LENGTH(customer.org) ASC, customer.org ASC;
END;;

-- SETTERS

CREATE PROCEDURE set_customer
(IN
    _family_name VARCHAR(80),
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
    VALUES(
        _family_name,
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

-- UNSETTERS

CREATE PROCEDURE unset_customer
(IN _id INTEGER UNSIGNED)
BEGIN
    DELETE
    FROM customer
    WHERE id = _id;
END;;

CREATE PROCEDURE unset_all_customers
()
BEGIN
    DELETE
    FROM customer;
END;;

CREATE PROCEDURE unset_all_files_customers
(IN _id INTEGER UNSIGNED)
BEGIN
    DELETE
    FROM customer
    WHERE id IN (
        SELECT DISTINCT activity.customer_id
        FROM activity, reference
        WHERE reference.file_id = _id
            AND reference.activity_id = activity.id
    );
END;;

-- RESETTERS

CREATE PROCEDURE reset_customer
(IN
    _id INTEGER UNSIGNED,
    _family_name VARCHAR(80),
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
    _url VARCHAR(80))
BEGIN
    UPDATE customer
    SET
        family_name = _family_name,
        given_name = _given_name,
        additional_name = _additional_name,
        honorific_prefix = _honorific_prefix,
        honorific_suffix = _honorific_suffix,
        role = _role,
        org = _org,
        post_office_box = _post_office_box,
        street_address = _street_address,
        extended_address = _extended_address,
        locality = _locality,
        region = _region,
        postal_code = _postal_code,
        country_name = _country_name,
        tel = _tel,
        email = _email,
        url = _url
    WHERE id = _id;
END;;

-- MISC.

CREATE PROCEDURE is_org_name
(IN _org VARCHAR(80))
BEGIN
    IF _org IS NULL
    THEN
        SELECT 1;
    ELSE
        SELECT COUNT(*)
        FROM customer
        WHERE org = _org;
    END IF;
END;;

DELIMITER ;
