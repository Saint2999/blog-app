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

    
                if (str_contains($filename, 'article')) {
                    $lorem = strip_tags(file_get_contents('http://loripsum.net/api/1/long'));
                    $statement->execute(['lorem' => $lorem]);
                } else if (str_contains($filename, 'comment')) {
                    $lorem = strip_tags(file_get_contents('http://loripsum.net/api/1/short'));
                    $statement->execute(['lorem' => $lorem]);
                } else {
                    $statement->execute();
                }
            }
        }
    }
}