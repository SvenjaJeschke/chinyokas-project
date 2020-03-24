<?php

header("Access-Control-Allow-Origin: *");

require_once('../../Database.php');

$pdo = Database::connect();
$selectImagePosts = $pdo->prepare('select * from image_posts');
$selectImagePosts->execute();
$imagePosts = $selectImagePosts->fetchAll(PDO::FETCH_OBJ);

echo json_encode($imagePosts);