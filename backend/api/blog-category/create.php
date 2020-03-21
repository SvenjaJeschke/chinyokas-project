<?php

header("Access-Control-Allow-Origin: *");

require('../../BlogCategory.php');
require('../../helpers.php');

$body = file_get_contents('php://input');
$json = json_decode($body, true);

$name = $json['name'];

$message = BlogCategory::create($name);

echo json_encode(['message' => $message]);