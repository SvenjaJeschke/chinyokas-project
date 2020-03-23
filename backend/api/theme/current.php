<?php

header("Access-Control-Allow-Origin: *");

require('../../helpers.php');
require_once('../../Database.php');

$pdo = Database::connect();
$selectCurrentTheme = $pdo->prepare('select * from themes where is_current = 1');
$selectCurrentTheme->execute();
$theme = $selectCurrentTheme->fetchAll(PDO::FETCH_OBJ);

echo json_encode($theme[0]);