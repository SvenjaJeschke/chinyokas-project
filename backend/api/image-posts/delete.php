<?php

header("Access-Control-Allow-Origin: *");

require('../../helpers.php');
require_once('../../Database.php');

$body = file_get_contents('php://input');
$json = json_decode($body, true);

$id = $json['id'];

$pdo = Database::connect();
$deletePost = $pdo->prepare("delete from image_posts where id = {$id}");
$deletePost->execute();

echo json_encode(['message' => 'The image post was deleted.']);