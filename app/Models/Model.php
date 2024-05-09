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

    public static final function allWithLimit(int $offset, int $count): array
    {
        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * FROM " . static::table . " LIMIT :offset, :count");

        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
        $statement->bindParam(':count', $count, PDO::PARAM_INT);

        $statement->execute();

        $statement->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        return $statement->fetchAll();
    }

    public static final function count(): int
    {
        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * FROM " . static::table . "");

        $statement->execute();

        return $statement->rowCount();
    }

    public static final function find(string $id): ?Model
    {
        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * FROM " . static::table . " WHERE id = :id");

        $statement->execute(['id' => $id]);
        
        $statement->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $model = $statement->fetch();

        if (!$model) {
            return null;
        }

        return $model;
    }

    public static final function where(string $column, string $value): array
    {
        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * FROM " . static::table . " WHERE $column = :value");

        $statement->execute(['value' => $value]);

        $statement->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        return $statement->fetchAll();
    }

    public static final function whereAndOrderBy(
        string $whereColumn, 
        string $value, 
        string $orderColumn,
        string $order
    ): array
    {
        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * FROM " . static::table . " WHERE $whereColumn = :value ORDER BY $orderColumn $order");

        $statement->execute(['value' => $value]);

        $statement->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        return $statement->fetchAll();
    }

    public static final function whereAndWhere(
        string $firstColumn, 
        string $firstValue,
        string $secondColumn, 
        string $secondValue
    ): array
    {
        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * FROM " . static::table . " WHERE $firstColumn = :firstValue AND $secondColumn = :secondValue");

        $statement->execute(['firstValue' => $firstValue, 'secondValue' => $secondValue]);

        $statement->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        return $statement->fetchAll();
    }

    public static final function create(array $attributes): ?Model
    {
        $pdo = Database::connect();

        $statement = $pdo->prepare(
            "INSERT INTO " . static::table . " (" . implode(", ", array_keys($attributes)) . ") 
            VALUES (:" . implode(", :", array_keys($attributes)) . ")"
        );

        $statement->execute($attributes);

        return self::find($pdo->lastInsertId());
    }

    public static final function update(array $attributes, string $id): ?Model
    {
        $pdo = Database::connect();

        $updateAttributes = array();
        foreach (array_keys($attributes) as $name) {
            $updateAttributes[] = "$name = :$name";
        }

        $statement = $pdo->prepare(
            "UPDATE " . static::table . " SET " . implode(", ", $updateAttributes) . 
            " WHERE id = :id"
        );

        $statement->execute(array_merge($attributes, ['id' => $id]));

        if (!$statement->rowCount()) {
            return null;
        }

        return self::find($id);
    }

    public static final function delete(string $id): bool
    {
        $pdo = Database::connect();

        $statement = $pdo->prepare("DELETE FROM " . static::table . " WHERE id = :id");

        $statement->execute(['id' => $id]);

        if ($statement->rowCount() <= 0) {
            return false;
        }

        return true;
    }
}