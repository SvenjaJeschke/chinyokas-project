<?php

header("Access-Control-Allow-Origin: *");

require('../../helpers.php');
require_once('../../Database.php');

$body = file_get_contents('php://input');
$json = json_decode($body, true);

$id = $json['id'];

$pdo = Database::connect();

$updateCurrentTheme = $pdo->prepare('update themes set is_current = 0 where is_current = 1');
$updateCurrentTheme->execute();

$setNewCurrentTheme = $pdo->prepare("update themes set is_current = 1 where id = {$id}");
$setNewCurrentTheme->execute();

echo json_encode(['message' => 'Theme was changed.']);