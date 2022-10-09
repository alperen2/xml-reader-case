<?php

namespace App;

use App\Config;
use PDO;

class Database {
    
    public $conn;

    public function __construct(Config $config)
    {
        if (is_null($this->conn)) {
            $conn = new \PDO("pgsql:host={$config->get('DB_HOST')};port={$config->get('DB_PORT')};dbname={$config->get('DB_NAME')};", $config->get('DB_USER'), $config->get('DB_PASSWORD'));
            $this->setConn($conn);
        }
    }

    /**
     * @return PDO;
     */
    public function getConn(): PDO
    {
        return $this->conn;
    }

    /**
     * @param PDO $conn
     * @return self;
     */
    public function setConn($conn): self
    {
        $this->conn = $conn;

        return $this;
    }
}