<?php

header("Access-Control-Allow-Origin: *");

require('../../helpers.php');
require_once('../../Database.php');

$body = file_get_contents('php://input');
$json = json_decode($body, true);

$id = $json['id'];

$pdo = Database::connect();
$deleteSong = $pdo->prepare("
    delete from songs where id = {$id}
");
$deleteSong->execute();

echo json_encode(['message' => 'Song was removed from the playlist.']);