<?php

header("Access-Control-Allow-Origin: *");

require('../../controllers/BlogCategoryController.php');
require('../../helpers.php');

$body = file_get_contents('php://input');
$json = json_decode($body, true);

$id = $json['id'];

$message = BlogCategoryController::delete($id);

echo json_encode(['message' => $message]);