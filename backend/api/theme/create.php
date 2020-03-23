<?php

header("Access-Control-Allow-Origin: *");

require('../../helpers.php');
require_once('../../Database.php');

$body = file_get_contents('php://input');
$json = json_decode($body, true);

$theme = $json['theme'];

$pdo = Database::connect();
$createTheme = $pdo->prepare("
    insert into themes
    (backgroundImage, borderColor, navbarType, is_current)
    values (
        '{$theme['backgroundImage']}',
        '{$theme['borderColor']}',
        '{$theme['navbarType']}',
        0
    )"
);
$createTheme->execute();

echo json_encode(['message' => 'Theme was created.']);