<?php

namespace App\utils;

use PDO;

class DB
{

    private static ?PDO $database;


    static function getPDO(): PDO
    {
        if (!isset($database)) {
            self::$database = new PDO(
                "mysql:host=localhost:3306;dbname=eshop;",
                "abdou",
                "aziz",
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,
                ]
            );
        }
        return self::$database;
    }
}