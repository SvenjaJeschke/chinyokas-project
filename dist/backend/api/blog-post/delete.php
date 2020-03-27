<?php

header("Access-Control-Allow-Origin: *");

require('../../helpers.php');
require_once('../../Database.php');

$body = file_get_contents('php://input');
$json = json_decode($body, true);
$id = $json['id'];

$pdo = Database::connect();
$deleteBlogPost = $pdo->prepare("delete from blog_posts where id = {$id}");
$deleteBlogPost->execute();

echo json_encode(['message' => 'Blog Post was deleted.']);