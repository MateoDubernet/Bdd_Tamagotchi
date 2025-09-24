<?php
namespace Database;

use PDO;
use PDOStatement;

class Database {
    private static array $config = [
        "host" => "localhost",
        "port" => 3306,
        "username" => "root",
        "password" => "root",
        "engine" => "mysql",
    ];

    private static string $database = "tamagotchi";
    private static ?PDO $pdo = null;

    public static function connect(): PDO {
        if (self::$pdo === null) {
            $dsn = sprintf(
                "%s:host=%s;port=%s;dbname=%s;charset=utf8mb4",
                self::$config["engine"],
                self::$config["host"],
                self::$config["port"],
                self::$database
            );
            try {
                self::$pdo = new PDO($dsn, self::$config["username"], self::$config["password"], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                die("Erreur connexion BDD : " . $e->getMessage());
            }
        }
        return self::$pdo;
    }

    public static function query(string $sql, array $params = []): PDOStatement {
        $pdo = self::connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public static function fetchAll(string $sql, array $params = []): array {
        return self::query($sql, $params)->fetchAll();
    }

    public static function fetchOne(string $sql, array $params = []): ?array {
        $result = self::query($sql, $params)->fetch();
        return $result ?: null;
    }

    public static function insert(string $sql, array $params = []): int {
        self::query($sql, $params);
        return self::connect()->lastInsertId();
    }

    public static function useDatabase(string $databaseName): void {
        self::$database = $databaseName;
        self::$pdo = null; // forcera la reconnexion à la prochaine query
    }
}
