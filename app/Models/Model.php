<?php

namespace app\Models;

use PDO;
use app\Core\Database;

class Model
{
    public static final function all(): array
    {
        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * FROM " . static::table . "");

        $statement->execute();

        $statement->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        return $statement->fetchAll();
    }

    public static final function find(string $id): Model
    {
        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * FROM " . static::table . " WHERE id = :id");

        $statement->execute(['id' => $id]);
        
        $statement->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        return $statement->fetch();
    }

    public static final function where(string $column, string $value): array
    {
        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * FROM " . static::table . " WHERE $column = :value ;");

        $statement->execute(['value' => $value]);

        $statement->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        return $statement->fetchAll();
    }

    public static final function create(array $attributes): Model
    {
        $pdo = Database::connect();

        $statement = $pdo->prepare(
            "INSERT INTO " . static::table . " (" . implode(", ", array_keys($attributes)) . ") 
            VALUES (:" . implode(", :", array_keys($attributes)) . ")"
        );

        $statement->execute($attributes);

        return self::find($pdo->lastInsertId());
    }

    public static final function update(string $id, array $attributes): int
    {
        $pdo = Database::connect();

        $updateAttributes = array();
        foreach (array_keys($attributes) as $name) {
            $updateAttributes[] = "`$name` = :`$name`";
        }

        $statement = $pdo->prepare(
            "UPDATE " . static::table . " SET" . implode(", ", $updateAttributes) . 
            "WHERE id = :id"
        );

        $statement->execute($attributes);

        return $statement->rowCount();
    }

    public static final function delete(string $id): int
    {
        $pdo = Database::connect();

        $statement = $pdo->prepare("DELETE FROM " . static::table . " WHERE id = :id");

        $statement->execute(['id' => $id]);

        return $statement->rowCount();
    }
}