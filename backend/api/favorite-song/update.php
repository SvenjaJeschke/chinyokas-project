<?php

header("Access-Control-Allow-Origin: *");

require('../../helpers.php');
require_once('../../Database.php');

$body = file_get_contents('php://input');
$json = json_decode($body, true);

$name = addslashes($json['song']['name']);
$url = $json['song']['url'];

$pdo = Database::connect();

$updateFavoriteSong = $pdo->prepare("
    update favorite_song set
    name = '{$name}',
    url = '{$url}'
");
$updateFavoriteSong->execute();

echo json_encode(['message' => 'Your favorite song was updated.']);