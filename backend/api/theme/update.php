<?php

header("Access-Control-Allow-Origin: *");

require('../../helpers.php');
require_once('../../Database.php');

$body = file_get_contents('php://input');
$json = json_decode($body, true);

$theme = $json['theme'];

$pdo = Database::connect();
$updateTheme = $pdo->prepare("
    update themes
    set
    backgroundImage = '{$theme['backgroundImage']}',
    borderColor = '{$theme['borderColor']}',
    navbarType = '{$theme['navbarType']}'
    where
    id = {$theme['id']}
");
$updateTheme->execute();

echo json_encode(['message' => 'Theme was updated.']);