<?php

class Database {
    public static function connect() {
        try {
            $pdo = new PDO('mysql:host=127.0.0.1;dbname=chinyokas_project', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOExeption $e) {
            die('Task failed successfully: ' . $e->getMessage());
        }
    }
}