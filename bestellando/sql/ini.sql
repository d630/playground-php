START TRANSACTION;

SET foreign_key_checks=0;

DROP DATABASE IF EXISTS bestellando;
CREATE DATABASE bestellando;
USE bestellando;

CREATE TABLE dish (
    id TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    uuid BIGINT UNSIGNED NULL,
    name VARCHAR(40),
    note VARCHAR(255),
    price DOUBLE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE ttable (
    id TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    uuid BIGINT UNSIGNED NULL,
    num INTEGER
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE oorder (
    id INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    uuid BIGINT UNSIGNED NULL,
    ctime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ttable_id TINYINT UNSIGNED,
    dish_id TINYINT UNSIGNED,
    is_paid BOOLEAN DEFAULT FALSE,
    is_servable BOOLEAN DEFAULT FALSE,
    is_served BOOLEAN DEFAULT FALSE,
    FOREIGN KEY(dish_id) REFERENCES dish(id),
    FOREIGN KEY(ttable_id) REFERENCES ttable(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE backlog (
    id INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    ctime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    oorder_ctime TIMESTAMP NULL,
    oorder_uuid BIGINT UNSIGNED,
    ttable_uuid BIGINT UNSIGNED,
    dish_uuid BIGINT UNSIGNED
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- STORED PROCS AND FUNCS

DELIMITER ;;

CREATE PROCEDURE get_all_dishes
()
BEGIN
    SELECT id, name, note, price
    FROM dish;
END;;

CREATE PROCEDURE get_all_dishes_short
()
BEGIN
    SELECT id, name
    FROM dish;
END;;

CREATE PROCEDURE get_all_tables
()
BEGIN
    SELECT id, num
    FROM ttable;
END;;

CREATE PROCEDURE set_order
(IN _ttable_id TINYINT UNSIGNED, _dish_id TINYINT UNSIGNED)
BEGIN
    INSERT INTO oorder(ttable_id, dish_id)
    VALUES(_ttable_id, _dish_id);
END;;

CREATE PROCEDURE get_all_unservable_orders
()
BEGIN
    SELECT oorder.id, oorder.ttable_id, ttable.num AS ttable_num, dish.name
    FROM oorder, dish, ttable
    WHERE oorder.ttable_id = ttable.id
    AND oorder.dish_id = dish.id
    AND oorder.is_servable = 0;
END;;

CREATE PROCEDURE get_all_unservable_tables
()
BEGIN
    SELECT oorder.ttable_id, ttable.num
    FROM oorder, ttable
    WHERE oorder.ttable_id = ttable.id
    AND oorder.is_servable = 0;
END;;

CREATE PROCEDURE get_all_ready_orders
()
BEGIN
    SELECT oorder.id, oorder.ttable_id, ttable.num AS ttable_num, dish.name
    FROM oorder, dish, ttable
    WHERE oorder.ttable_id = ttable.id
    AND oorder.dish_id = dish.id
    AND oorder.is_servable = 1
    AND oorder.is_served = 0;
END;;

CREATE PROCEDURE get_all_ready_tables
()
BEGIN
    SELECT oorder.ttable_id, ttable.num
    FROM oorder, ttable
    WHERE oorder.ttable_id = ttable.id
    AND oorder.is_servable = 1
    AND oorder.is_served = 0;
END;;

CREATE PROCEDURE get_all_unpaid_orders
()
BEGIN
    SELECT oorder.id, oorder.ttable_id, ttable.num AS ttable_num, dish.name
    FROM oorder, dish, ttable
    WHERE oorder.ttable_id = ttable.id
    AND oorder.dish_id = dish.id
    AND oorder.is_paid = 0;
END;;

CREATE PROCEDURE get_all_unpaid_tables
()
BEGIN
    SELECT oorder.ttable_id, ttable.num
    FROM oorder, ttable
    WHERE oorder.ttable_id = ttable.id
    AND oorder.is_paid = 0;
END;;

CREATE PROCEDURE get_all_unpaid_orders_with_price
()
BEGIN
    SELECT oorder.id, oorder.ttable_id, ttable.num AS ttable_num, dish.name, dish.price
    FROM oorder, dish, ttable
    WHERE oorder.ttable_id = ttable.id
    AND oorder.dish_id = dish.id
    AND oorder.is_paid = 0;
END;;

CREATE PROCEDURE delete_unpaid_order
(IN _id INTEGER UNSIGNED)
BEGIN
    DELETE
    FROM oorder
    WHERE id = _id;
END;;

CREATE PROCEDURE update_unservable_order
(IN _id INTEGER UNSIGNED)
BEGIN
    UPDATE oorder
    SET is_servable = 1
    WHERE id = _id;

    CALL on_ready(_id);
END;;

CREATE PROCEDURE update_unserved_order
(IN _id INTEGER UNSIGNED)
BEGIN
    UPDATE oorder
    SET is_served = 1
    WHERE id = _id;

    CALL on_ready(_id);
END;;

CREATE PROCEDURE update_unpaid_order
(IN _id INTEGER UNSIGNED)
BEGIN
    UPDATE oorder
    SET is_paid = 1
    WHERE id = _id;

    CALL on_ready(_id);
END;;

CREATE PROCEDURE on_ready
(IN _id INTEGER UNSIGNED)
BEGIN
    IF is_ready(_id) THEN
        CALL move_order(_id);
    END IF;
END;;

CREATE FUNCTION is_ready
(_id INTEGER UNSIGNED)
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    DECLARE ret BOOLEAN;

    SELECT is_servable AND is_served AND is_paid
    INTO ret
    FROM oorder
    WHERE id = _id;

    return ret;
END;;

CREATE PROCEDURE move_order
(IN _id INTEGER UNSIGNED)
BEGIN
    INSERT INTO backlog (oorder_ctime, oorder_uuid, ttable_uuid, dish_uuid)
    SELECT oorder.ctime, oorder.uuid, ttable.uuid, dish.uuid
    FROM oorder, ttable, dish
    WHERE oorder.id = _id
        AND oorder.ttable_id = ttable.id
        AND oorder.dish_id = dish.id;

    DELETE
    FROM oorder
    WHERE id = _id;
END;;

DELIMITER ;

-- TRIGGERS.

DELIMITER ;;

CREATE TRIGGER before_insert_dish
BEFORE INSERT ON dish
FOR EACH ROW
BEGIN
    IF new.uuid IS NULL THEN
        SET new.uuid = UUID_SHORT();
    END IF;
END;;

CREATE TRIGGER before_insert_ttable
BEFORE INSERT ON ttable
FOR EACH ROW
BEGIN
    IF new.uuid IS NULL THEN
        SET new.uuid = UUID_SHORT();
    END IF;
END;;

CREATE TRIGGER before_insert_oorder
BEFORE INSERT ON oorder
FOR EACH ROW
BEGIN
    IF new.uuid IS NULL THEN
        SET new.uuid = UUID_SHORT();
    END IF;
END;;

DELIMITER ;

-- INSERTS.

INSERT INTO dish (name, note, price)
VALUES ('dish0', 'foo bar', 5.99),
('dish1', 'foo bar', 5.99),
('dish2', 'foo bar', 12.99),
('dish3', 'foo bar', 13.99),
('dish4', 'foo bar', 1.99),
('dish5', 'foo bar', 2.99),
('dish6', 'foo bar', 5.99),
('dish7', 'foo bar', 8.99),
('dish8', 'foo bar', 5.99),
('dish9', 'foo bar', 9.99);

INSERT INTO ttable (num)
VALUES(1),
(2),
(3),
(4),
(5),
(6),
(7),
(9),
(15);

INSERT INTO oorder (ttable_id, dish_id)
VALUES (1, 9),
(1, 2),
(1, 3),
(3, 4),
(3, 2),
(7, 1),
(9, 2);

COMMIT;

-- vim: set ft=sql :
