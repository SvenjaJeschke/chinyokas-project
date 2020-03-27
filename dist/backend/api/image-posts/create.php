<?php

header("Access-Control-Allow-Origin: *");

require('../../helpers.php');
require_once('../../Database.php');

$title = $_POST['title'];
$description = $_POST['description'];
$image = $_FILES['file'];

$post = [
    'title' => $title,
    'description' => $description,
    'image' => $image
];

$post['title'] = addslashes(htmlspecialchars($post['title']));
$post['description'] = addslashes(htmlspecialchars($post['description']));

$uploaddir = './../../../images/';
$filename = uniqid() . '_' . basename($image['name']);
$uploadfile = $uploaddir . $filename;
move_uploaded_file($image['tmp_name'], $uploadfile);

$imagePath = "./images/{$filename}";

$pdo = Database::connect();
$createPost = $pdo->prepare("
    insert into image_posts
    (title, description, image)
    values (
        '{$post['title']}',
        '{$post['description']}',
        '{$imagePath}'
    )"
);
$createPost->execute();

echo json_encode(['message' => 'Your new image post was created.']);