<?php

header("Access-Control-Allow-Origin: *");

require('../../controllers/PlaylistController.php');
require('../../helpers.php');

$body = file_get_contents('php://input');
$json = json_decode($body, true);

$name = $json['params']['name'];
$url = $json['params']['url'];

$urlStringSplit = explode('/', $url);

array_insert($urlStringSplit, 3, 'embed');

$url = implode('/', $urlStringSplit);

PlaylistController::create($name, $url);