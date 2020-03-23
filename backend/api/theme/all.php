<?php

header("Access-Control-Allow-Origin: *");

require_once('../../Database.php');

$pdo = Database::connect();
$selectThemes = $pdo->prepare('select * from themes');
$selectThemes->execute();
$themes = $selectThemes->fetchAll(PDO::FETCH_OBJ);

foreach ($themes as $theme) {
    $theme->is_current = $theme->is_current === '1';
}

echo json_encode($themes);