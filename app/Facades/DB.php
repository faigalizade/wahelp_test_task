<?php

namespace App\Facades;

use App\Database;
use PDO;

class DB
{
    public static function migrate($file): void
    {
        self::execute(file_get_contents($file));
    }

    public static function execute($query): false|int
    {
        $db = Database::getInstance();
        return $db->execute($query);
    }
    public static function create($query): false|string
    {
        $db = Database::getInstance();
        $db->execute($query);
        return $db->getConnection()->lastInsertId();
    }

    public static function getAll($table): array|false
    {
        $statement = self::prepare("SELECT * FROM {$table}");
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getOne($table, $value, $column = 'id')
    {
        $statement = self::prepare("SELECT * FROM {$table} where {$column} = '{$value}'");
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function get($sql)
    {
        $statement = self::prepare($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    private static function prepare($sql)
    {
        $db = Database::getInstance();
        $statement = $db->getConnection()->prepare($sql);
        $statement->execute();
        return $statement;
    }
}