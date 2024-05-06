<?php

namespace app\Core;

use PDO;
use app\Helpers\Env;

class Database
{
    private static ?PDO $pdo = null;

    public static function connect(): PDO
    {
        if (self::$pdo != null) {
            return self::$pdo;
        }
        
        self::$pdo = new PDO(
            sprintf(
                'mysql:host=%s;dbname=%s',
                Env::get('DB_HOST'),
                Env::get('DB_NAME'),
            ),
            Env::get('DB_USER'),
            Env::get('DB_PASS')
        );

        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        self::$pdo->setAttribute(PDO::MYSQL_ATTR_FOUND_ROWS, true);

        return self::$pdo;
    }
}