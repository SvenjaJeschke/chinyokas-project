<?php

require_once('./Database.php');

$pdo = Database::connect();

$password = password_hash('enter password here', PASSWORD_BCRYPT);

$setPassword = $pdo->prepare("insert into admin_data (password) values ('{$password}')");
$setPassword->execute();

echo 'admin passwort set';