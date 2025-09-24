<?php
namespace Models;

require_once __DIR__ . '/../vendor/autoload.php';

use Database\Database;
use BadMethodCallException;

abstract class Model {
    // Nom de la table et de la colonne ID (static, partagé par toutes les instances)
    protected static string $table = "";
    protected static string $idColumn = "";
    protected static array $columns = [];

    // Valeurs d’instance pour chaque enregistrement
    protected array $attributes = [];

    // Accès aux attributs via magic methods
    public function __get(string $name) {
        return $this->attributes[$name] ?? null;
    }

    public function __set(string $name, $value): void {
        $this->attributes[$name] = $value;
    }

    // Récupérer tous les enregistrements
    public static function getAll(): array {
        $rows = Database::fetchAll("SELECT * FROM " . static::$table);
        return array_map(fn($data) => self::hydrate($data), $rows);
    }

    // Récupérer par ID
    public static function getById(int $id): ?static {
        $row = Database::fetchOne(
            "SELECT * FROM " . static::$table . " WHERE " . static::$idColumn . " = :id",
            ['id' => $id]
        );
        return $row ? self::hydrate($row) : null;
    }

    // Récupérer par nom
    public static function getByName(string $name): ?static {
        $row = Database::fetchOne(
            "SELECT * FROM " . static::$table . " WHERE name = :name",
            ['name' => $name]
        );
        return $row ? self::hydrate($row) : null;
    }

    // Insertion
    public function insert(): void {
        $placeholders = array_map(fn($c) => ":$c", static::$columns);
        $params = [];
        foreach (static::$columns as $col) {
            $params[$col] = $this->$col ?? null;
        }

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            static::$table,
            implode(", ", static::$columns),
            implode(", ", $placeholders)
        );

        $this->{static::$idColumn} = Database::insert($sql, $params);
    }

    // Mise à jour
    public function updateAttributes(array $props): void {
        if (empty($props)) return;

        $setParts = [];
        $params = [];
        foreach ($props as $col => $val) {
            if (!in_array($col, static::$columns, true)) {
                throw new BadMethodCallException("Colonne $col inexistante dans " . static::class);
            }
            $setParts[] = "$col = :$col";
            $params[$col] = $val;
            $this->$col = $val; // mise à jour de l’instance
        }

        $params[static::$idColumn] = $this->{static::$idColumn};

        $sql = sprintf(
            "UPDATE %s SET %s WHERE %s = :%s",
            static::$table,
            implode(", ", $setParts),
            static::$idColumn,
            static::$idColumn
        );

        Database::query($sql, $params);
    }

    // Suppression
    public function deleteById(): void {
        if (!$this->{static::$idColumn}) {
            throw new BadMethodCallException("Impossible de supprimer : id manquant");
        }
        Database::query(
            "DELETE FROM " . static::$table . " WHERE " . static::$idColumn . " = :id",
            ['id' => $this->{static::$idColumn}]
        );
    }

    // Hydratation
    private static function hydrate(array $data): static {
        $obj = new static();
        foreach ($data as $key => $value) {
            $obj->$key = $value;
        }
        return $obj;
    }
}
