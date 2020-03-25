<?php

class Database {
    public static function connect() {
        try {
            $db = parse_url('postgresql://localhost:5432');
            $pdo = new PDO(
                "pgsql:" . sprintf(
                    "host=localhost;port=5432;user=root;password=phfjccxF;dbname=postgresql-dimensional-70874",
                    $db["host"],
                    $db["port"],
                    $db["user"],
                    $db["pass"],
                    ltrim($db["path"], "/")
                )
            );
            return $pdo;
        } catch (Exeption $e) {
            die('Connection Error');
        }
    }
}