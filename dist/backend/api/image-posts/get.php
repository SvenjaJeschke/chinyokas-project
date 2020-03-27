<?php

header("Access-Control-Allow-Origin: *");

require('../../helpers.php');
require_once('../../Database.php');

$id = $_GET['id'];

$pdo = Database::connect();
$selectImagePost = $pdo->prepare("select * from image_posts where id = {$id}");
$selectImagePost->execute();
$post = $selectImagePost->fetch(PDO::FETCH_OBJ);

echo json_encode($post);