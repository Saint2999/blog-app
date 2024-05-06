<?php

namespace app\Core;

use PDO;

class Seeders
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->connect();
    }

    public function run(): void 
    {
        foreach (glob('../../database/seeders/*.sql') as $filename)
        {
            $query = file_get_contents($filename);

            $this->pdo->query($query);
        }
    }
}