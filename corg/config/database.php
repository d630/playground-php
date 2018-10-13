<?php

return [
    'user' => 'corg',
    'password' => 'password',
    'dsn' => 'mysql:host=localhost;dbname=corg;charset=utf8mb4',
    'pdo' => [
        \PDO::ATTR_CASE => \PDO::CASE_NATURAL,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES => false,
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_ORACLE_NULLS => \PDO::NULL_EMPTY_STRING,
        \PDO::ATTR_PERSISTENT => false,
        \PDO::ATTR_STRINGIFY_FETCHES => true,
        \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false
    ]
];
