<?php

header("Access-Control-Allow-Origin: *");

require_once('../../Database.php');

$password = $_GET['password'];

$pdo = Database::connect();

$selectPassword = $pdo->prepare('select password from admin_data');
$selectPassword->execute();

if ($password && $selectPassword->fetchColumn() === $password) {
    echo json_encode(['admin' => true]);
} else {
    echo json_encode(['admin' => false]);
}