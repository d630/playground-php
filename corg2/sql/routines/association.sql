--
-- ASSOCIATION
--

DELIMITER ;;

-- GETTERS

CREATE PROCEDURE get_all_associations
()
BEGIN
    SELECT *
    FROM association;
END;;

CREATE PROCEDURE get_all_customers_associations
(IN _id INT UNSIGNED)
BEGIN
    SELECT customer.*
    FROM association, customer
    WHERE association.customer_id_1 = customer.id
        AND association.customer_id_2 = _id
    UNION
    SELECT customer.*
    FROM association, customer
    WHERE association.customer_id_2 = customer.id
        AND association.customer_id_1 = _id
    ORDER BY LENGTH(org) ASC, org ASC;
END;;

CREATE PROCEDURE get_all_customers_associations_small
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

CREATE PROCEDURE get_all_customers_associations_tiny
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

-- SETTERS

CREATE PROCEDURE set_association
(IN _customer_id_1 INTEGER UNSIGNED, _customer_id_2 INTEGER UNSIGNED)
BEGIN
    INSERT INTO association
    VALUES (_customer_id_1, _customer_id_2);
END;;

-- UNSETTERS

CREATE PROCEDURE unset_all_associations
()
BEGIN
    DELETE
    FROM association;
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

CREATE PROCEDURE unset_all_customers_associations
(IN _id INTEGER UNSIGNED)
BEGIN
    DELETE
    FROM association
    WHERE customer_id_1 = _id
        OR customer_id_2 = _id;
END;;

-- MISC

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

CREATE PROCEDURE check_association_pair
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

DELIMITER ;
