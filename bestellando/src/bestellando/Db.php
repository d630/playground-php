<?php
namespace bestellando;

class Db
{
    static protected $instance;
    protected $connction;

    protected function __construct()
    {
        $config = \bestellando\Config::get('database');

        //TODO: move PDO config
        // try {
            $this->connection = new \PDO(
                $config['dsn'] ,
                $config['user'],
                $config['password'],
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_PERSISTENT => false,
                    \PDO::ATTR_EMULATE_PREPARES => false,
                    \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false
                ]
            );
        // } catch (\Exception $e) {
        //     echo nl2br('error: can not connect to database');
            //header('Location: /index.php');
            // exit;
        // }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    static public function getInstance()
    {
        if (!(static::$instance instanceof static)) {
            static::$instance = new static();
        }

        return static::$instance->getConnection();
    }
}
