--
-- INSERTS.
--

SET foreign_key_checks=0;

INSERT INTO logi(ttable)
VALUES ('customer'), ('activity'), ('file');

INSERT INTO employee(nickname, password)
VALUES ('employee1', '$2y$10$l/qL9r8kkJ1etztpYz1SNuHxg/j0aDSOnj/ZVBd5pbP0wRSaBf.RW'),
('employee2', '$2y$10$l/qL9r8kkJ1etztpYz1SNuHxg/j0aDSOnj/ZVBd5pbP0wRSaBf.RW'),
('employee3', '$2y$10$l/qL9r8kkJ1etztpYz1SNuHxg/j0aDSOnj/ZVBd5pbP0wRSaBf.RW');

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
VALUES ('nachname',
        'vorname',
        'mitelname',
        'dr.',
        'blub',
        'vertriebler',
        'org1',
        'z1233',
        'strasse 1',
        '1. OG',
        'Muenchen',
        'Bayern',
        12345,
        'Deutschland',
        '030 123456',
        'nachname@org1.de',
        'https://org1.de',
        1);

INSERT INTO customer(
    family_name,
    given_name,
    role,
    org,
    street_address,
    locality,
    postal_code,
    country_name,
    tel,
    email,
    url,
    employee_id)
VALUES (
        'nachname',
        'vorname',
        'vertriebler',
        'org2',
        'strasse 1',
        'Muenchen',
        12345,
        'Deutschland',
        '030 123456',
        'nachname@org2.de',
        'https://org2.de', 1
    ),

    (
        'nachname',
        'vorname',
        'vertriebler',
        'org3',
        'strasse 1',
        'Muenchen',
        12345,
        'Deutschland',
        '030 123456',
        'nachname@org3.de',
        'https://org3.de',
        1
   ),

    (
        'nachname',
        'vorname',
        'vertriebler',
        'org4',
        'strasse 1',
        'Muenchen',
        12345,
        'Deutschland',
        '030 123456',
        'nachname@org4.de',
        'https://org4.de',
        1
    ),

    (
        'nachname',
        'vorname',
        'vertriebler',
        'org11',
        'strasse 1',
        'Muenchen',
        12345,
        'Deutschland',
        '030 123456',
        'nachname@org11.de',
        'https://org11.de',
        1
    );

INSERT INTO activity(name, description, customer_id, employee_id)
VALUES ('activity1', 'foo bar lich', 1, 1),
('activity2', 'foo bar lich', 1, 1),
('activity3', NULL, 2, 2),
('activity4', NULL, 3, 2);

INSERT INTO association
VALUES (1, 2),
(3, 1),
(1, 4),
(2, 3);

INSERT INTO file(name, description, employee_id)
VALUES ('123.pdf', 'foo bar lich', 1),
('foo.txt', 'bla', 1),
('lich.html', 'bla', 1),
('bar.png', 'bla', 1);

INSERT INTO reference
VALUES (1, 1),
(1, 2),
(1, 3),
(2, 4),
(2, 1),
(3, 1),
(4, 2);

SET foreign_key_checks=1;
