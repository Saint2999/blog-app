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
        if ($this->pdo->query('SELECT * FROM users')->rowCount() > 0) {
            return;
        }

        foreach (glob(BASE_PATH . '/database/seeders/*.sql') as $filename)
        {
            $queries = file($filename);

            foreach ($queries as $query) {
                $statement = $this->pdo->prepare($query);

                if (str_contains($filename, 'user')) {
                    $statement->execute();
                } else {
                    $lorem = file_get_contents('http://loripsum.net/api/1/medium');
                    $statement->execute(['lorem' => $lorem]);
                }
            }
        }
    }
}