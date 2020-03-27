<?php

header("Access-Control-Allow-Origin: *");

require('../../helpers.php');
require_once('../../Database.php');

$body = file_get_contents('php://input');
$json = json_decode($body, true);

$song = $json['song'];

$name = addslashes($song['name']);

$pdo = Database::connect();
$createSong = $pdo->prepare("
    insert into songs
    (name, url)
    values (
        '{$name}',
        '{$song['url']}'
    )"
);
$createSong->execute();

echo json_encode(['message' => 'Song was added to the playlist.']);