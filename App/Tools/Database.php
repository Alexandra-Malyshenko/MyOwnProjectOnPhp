<?php

namespace App\Tools;

use PDO;

class Database
{
    private static $instance = null;
    /**
     * @var array|false|string
     */
    private $host;
    /**
     * @var array|false|string
     */
    private $db_name;
    /**
     * @var array|false|string
     */
    private $user;
    /**
     * @var array|false|string
     */
    private $password;

    /**
     * @return Database
     */
    private function __construct()
    {
        $this->host = getenv('DB_HOST');
        $this->db_name = getenv('DB_NAME');
        $this->user = getenv('DB_USER');
        $this->password = getenv('DB_PASSWORD');
    }

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->db_name}";
        return new PDO($dsn, $this->user, $this->password);
    }
}