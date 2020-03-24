<?php

header("Access-Control-Allow-Origin: *");

require('../../helpers.php');
require_once('../../Database.php');

$pdo = Database::connect();
$selectLatestBlogPost = $pdo->prepare('select * from blog_posts order by created_at desc');
$selectLatestBlogPost->execute();
$latestBlogPost = $selectLatestBlogPost->fetch(PDO::FETCH_OBJ);
$selectCategory = $pdo->prepare("select * from blog_categories where id = {$latestBlogPost->category_id}");
$selectCategory->execute();
$category = $selectCategory->fetch(PDO::FETCH_OBJ);
$latestBlogPost->category = $category;

echo json_encode($latestBlogPost);