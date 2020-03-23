<?php

header("Access-Control-Allow-Origin: *");

require('../../controllers/BlogCommentController.php');

$blogId = $_GET['blog'];

$comments = BlogCommentController::blogComments($blogId);

echo json_encode($comments);