--
-- TABLES.
--

DELIMITER ;

CREATE TABLE logi (
    ttable VARCHAR(20),
    id INT UNSIGNED DEFAULT 0,
    itime TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY(ttable)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE employee (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nickname VARCHAR(80) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,

    PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE customer (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,

    family_name VARCHAR(80) NOT NULL,
    given_name VARCHAR(80) NOT NULL,
    additional_name VARCHAR(80),
    honorific_prefix VARCHAR(80),
    honorific_suffix VARCHAR(80),

    role VARCHAR(80) NOT NULL,
    org VARCHAR(80) NOT NULL UNIQUE,

    post_office_box VARCHAR(80),
    street_address VARCHAR(80),
    extended_address VARCHAR(80),
    locality VARCHAR(80),
    region VARCHAR(80),
    postal_code VARCHAR(80),
    country_name VARCHAR(80),

    tel VARCHAR(80),
    email VARCHAR(80),
    url VARCHAR(80),

    rev TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    employee_id INT UNSIGNED NOT NULL,

    PRIMARY KEY(id),
    INDEX(employee_id),

    FOREIGN KEY(employee_id)
        REFERENCES employee(id)
        ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE association (
    customer_id_1 INT UNSIGNED NOT NULL,
    customer_id_2 INT UNSIGNED NOT NULL,

    PRIMARY KEY(customer_id_1, customer_id_2),

    FOREIGN KEY(customer_id_1)
        REFERENCES customer(id)
        ON DELETE CASCADE ON UPDATE CASCADE,

    FOREIGN KEY(customer_id_2)
        REFERENCES customer(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE activity (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    mtime TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    name VARCHAR(80) NOT NULL,
    description TEXT,
    customer_id INT UNSIGNED NOT NULL,
    employee_id INT UNSIGNED NOT NULL,

    PRIMARY KEY(id),
    INDEX(customer_id),
    INDEX(employee_id),

    FOREIGN KEY(customer_id)
        REFERENCES customer(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(employee_id)
        REFERENCES employee(id)
        ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE file (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    mtime TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    size BIGINT UNSIGNED DEFAULT 0,
    mtype VARCHAR(80),
    name VARCHAR(80) NOT NULL,
    description TEXT,
    employee_id INT UNSIGNED NOT NULL,

    PRIMARY KEY(id),
    INDEX(employee_id),

    FOREIGN KEY(employee_id)
        REFERENCES employee(id)
        ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE reference (
    activity_id INT UNSIGNED NOT NULL,
    file_id INT UNSIGNED NOT NULL,

    PRIMARY KEY(activity_id, file_id),

    FOREIGN KEY(activity_id)
        REFERENCES activity(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(file_id)
        REFERENCES file(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
