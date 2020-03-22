<?php

header("Access-Control-Allow-Origin: *");

require('../../helpers.php');
require('../../Post.php');

$id = $_GET['id'];

$post = new Post($id, true);

echo json_encode($post);