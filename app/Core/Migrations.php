<?php

namespace app\Core;

use PDO;

class Migrations
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->connect();
    }

    public function run(): void 
    {
        foreach (glob(BASE_PATH . '/database/migrations/*.sql') as $filename)
        {
            $query = file_get_contents($filename);

            $statement = $this->pdo->prepare($query);

            $statement->execute();
        }
    }
}