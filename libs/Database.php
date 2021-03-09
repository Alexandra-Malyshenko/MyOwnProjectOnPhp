<?php

namespace libs;

use PDO;

class Database
{
    private static $instance = null;

    public static function getInstance(): ?Database
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param string|null $host
     * @param string|null $db_name
     * @param string|null $user
     * @param string|null $password
     * @return PDO
     */
    public function getConnection(
        ?string $host = null,
        ?string $db_name = null,
        ?string $user = null,
        ?string $password = null
    ): PDO {
        if (isset($host) && isset($db_name)) {
            $dsn = "mysql:host={$host};dbname={$db_name}";
            return new PDO($dsn, $user, $password);
        } else {
            $host = getenv('DB_HOST');
            $db_name = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $password = getenv('DB_PASSWORD');
            $dsn = "mysql:host={$host};dbname={$db_name}";
            return new PDO($dsn, $user, $password);
        }
    }
}