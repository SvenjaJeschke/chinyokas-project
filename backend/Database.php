<?php

class Database {
    public static function connect() {
        try {
            $db = parse_url('postgres://emmrvvjucbsocb:530fe930a0037e589731d229f827aad282a0ac5b48f5980586f5ebd801ea9647@ec2-54-75-246-118.eu-west-1.compute.amazonaws.com:5432/de16ktmetuerb3');
            $pdo = new PDO(
                "pgsql:" . sprintf(
                    "host=ec2-54-75-246-118.eu-west-1.compute.amazonaws.com;
                    port=5432;
                    user=emmrvvjucbsocb;
                    password=530fe930a0037e589731d229f827aad282a0ac5b48f5980586f5ebd801ea9647;
                    dbname=de16ktmetuerb3",
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