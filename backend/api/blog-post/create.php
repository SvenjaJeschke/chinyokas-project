<?php

header("Access-Control-Allow-Origin: *");

require('../../controllers/BlogPostController.php');
require('../../helpers.php');

$body = file_get_contents('php://input');
$json = json_decode($body, true);

$post = $json['post'];

$message = BlogPostController::create($post);

echo json_encode(['message' => $message]);