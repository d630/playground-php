<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db;

use D630\Corg\Config;

class Db
{
    private static $instance;
    private $connection;

    private function __construct()
    {
        $config = Config::get('database');

        $this->connection = new \PDO(
            $config['dsn'],
            $config['user'],
            $config['password'],
            $config['pdo']
        );
    }

    private function __clone()
    {
    }

    private function __wakeup(): void
    {
    }

    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance->getConnection();
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
