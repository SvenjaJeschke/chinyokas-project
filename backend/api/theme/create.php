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
    (backgroundimage, bordercolor, navbartype, is_current)
    values (
        '{$theme['backgroundimage']}',
        '{$theme['bordercolor']}',
        '{$theme['navbartype']}',
        false
    )"
);
$createTheme->execute();

echo json_encode(['message' => 'Theme was created.']);