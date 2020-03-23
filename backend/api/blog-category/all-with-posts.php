<?php

header("Access-Control-Allow-Origin: *");

require('../../helpers.php');
require('../../controllers/BlogCategoryController.php');

$categories = BlogCategoryController::allWithPosts();

echo json_encode($categories);