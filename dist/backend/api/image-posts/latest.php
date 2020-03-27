<?php

header("Access-Control-Allow-Origin: *");

require_once('../../Database.php');

$pdo = Database::connect();
$selectImagePosts = $pdo->prepare('select * from image_posts order by created_at desc');
$selectImagePosts->execute();
$imagePost = $selectImagePosts->fetch(PDO::FETCH_OBJ);

echo json_encode($imagePost);