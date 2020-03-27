<?php

header("Access-Control-Allow-Origin: *");

require('../../helpers.php');
require_once('../../Database.php');

$body = file_get_contents('php://input');
$json = json_decode($body, true);

$post = $json['post'];

$post['title'] = addslashes(htmlspecialchars($post['title']));
$post['description'] = addslashes(htmlspecialchars($post['description']));

$pdo = Database::connect();
$updatePost = $pdo->prepare("
    update image_posts set
    title = '{$post['title']}',
    description = '{$post['description']}'
    where id = {$post['id']}
");
$updatePost->execute();

echo json_encode(['message' => 'Your image post was updated.']);