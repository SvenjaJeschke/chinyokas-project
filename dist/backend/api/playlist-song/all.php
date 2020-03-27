<?php

header("Access-Control-Allow-Origin: *");

require('../../helpers.php');
require_once('../../Database.php');

$pdo = Database::connect();
$selectSongs = $pdo->prepare('select * from songs');
$selectSongs->execute();
$songs = $selectSongs->fetchAll(PDO::FETCH_OBJ);

foreach ($songs as $key => $song) {
    $songs[$key]->playlist_id = $key;
}

echo json_encode($songs);