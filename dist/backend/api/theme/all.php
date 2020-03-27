<?php

header("Access-Control-Allow-Origin: *");

require_once('../../Database.php');

$pdo = Database::connect();
$selectThemes = $pdo->prepare('select * from themes');
$selectThemes->execute();
$themes = $selectThemes->fetchAll(PDO::FETCH_OBJ);

echo json_encode($themes);