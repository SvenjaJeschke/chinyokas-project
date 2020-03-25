<?php

class Database {
    public static function connect() {
        try {
            $pdo = new PDO(
                "pgsql:" . sprintf(
                    "host=%s;port=%s;user=%s;password=%s;dbname=%s",
                    $db["host"],
                    $db["port"],
                    $db["user"],
                    $db["pass"],
                    ltrim($db["path"], "/")
                )
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOExeption $e) {
            die('Task failed successfully: ' . $e->getMessage());
        }
    }
}