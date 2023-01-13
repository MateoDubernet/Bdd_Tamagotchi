<?php

class AccessBdd {

    private static array $configBdd = [
        "host" => "localhost",
        "port" => 3306,
        "username" => "root",
        "password" => "root",
        "engine" => "mysql",
    ];

    private static function connect(){
        try {
            $pdo = new PDO(sprintf(
                "%s:host=%s:%s;dbname=%s",
                static::$config["engine"],
                static::$config["host"],
                static::$config["port"],
            ), static::$config["username"], static::$config["password"], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
            return $pdo;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function createDataBase(string $database){
        $pdo = self::connect();
        $stmt = $pdo->prepare(sprintf("CREATE DATABASE IF NOT EXISTS %s", $database));
        $stmt->exec();

        self::use($database);
    }

    public static function createTable(array $table){
        try {
            $pdo = self::connect();
            $sql = sprintf(
                "CREATE TABLE %s (%s, %s, %s, %s)", 
                $table['table_name'],
                $table['column_id'],
                $table['column_name'],
                $table['column_create'],
                $table['column_update']
            );
            $pdo->exec($sql);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}