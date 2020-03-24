<?php

header("Access-Control-Allow-Origin: *");

require('../../helpers.php');
require_once('../../Database.php');

$pdo = Database::connect();
$selectSong = $pdo->prepare('select * from favorite_song');
$selectSong->execute();
$song = $selectSong->fetch(PDO::FETCH_OBJ);

echo json_encode($song);