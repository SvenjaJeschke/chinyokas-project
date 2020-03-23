<?php

header("Access-Control-Allow-Origin: *");

require('../../controllers/BlogCommentController.php');

$body = file_get_contents('php://input');
$json = json_decode($body, true);

$comment = $json['comment'];

$message = BlogCommentController::create($comment);

echo json_encode(['message' => $message]);