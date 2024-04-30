<?php

namespace App;

use App\Singleton;
use PDO;
use PDOException;

class Database extends Singleton
{
    private PDO $connection;
    public function __construct($config)
    {
        try {
            $this->connection = new PDO("mysql:host={$config['host']};dbname={$config['database']}", $config['username'], $config['password']);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function execute($query)
    {
        return $this->connection->exec($query);
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}