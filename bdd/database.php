<?php

class DataBase {

    private static array $configBdd = [
        "host" => "localhost",
        "port" => 3306,
        "username" => "root",
        "password" => "root",
        "engine" => "mysql",
    ];

    private static string $database = "";

    private static function connect(){
        try {
            $pdo = new PDO(sprintf(
                "%s:host=%s:%s;dbname=%s",
                static::$configBdd["engine"],
                static::$configBdd["host"],
                static::$configBdd["port"],
                static::$database
            ), static::$configBdd["username"], static::$configBdd["password"], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
            return $pdo;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getAll($table){
        try {

            $pdo = self::connect();
            $sql = $pdo->prepare(sprintf("SELECT * FROM %s", $table));
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function createDataBase(string $database){
        $pdo = self::connect();
        $stmt = $pdo->prepare(sprintf("CREATE DATABASE IF NOT EXISTS %s", $database));
        $stmt->execute();
    }

    public static function createTable(array $table){
        try {
            $pdo = self::connect();
            $sql = sprintf("CREATE TABLE IF NOT EXISTS %s (", $table["table_name"]);

            unset($table["table_name"]);
            foreach($table as $column) {
                $sql .= sprintf("%s", $column);
            }
            $sql .= ")";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function useDataBase(string $database){
        $pdo = self::connect();
        self::createDataBase($database);

        $stmt = $pdo->prepare(sprintf("USE %s", $database));
        $stmt->execute();

        self::$database = $database;
    }

    public static function insertData(string $tableName, array $columns, array $values){
        try {
            $pdo = self::connect();
            $sql = sprintf("INSERT INTO %s (", $tableName);

            foreach($columns as $column) {
                $sql .= sprintf("%s", $column);
            }
            $sql .= ") VALUES (";

            foreach($values as $value) {
                $sql .= sprintf("%s", $value);
            }
            $sql .= ")";

            echo '<pre>';
            echo $sql;
            echo '</pre>';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}