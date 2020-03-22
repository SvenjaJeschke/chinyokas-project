<?php

header("Access-Control-Allow-Origin: *");

require('../../helpers.php');
require('../../BlogPost.php');

$id = $_GET['id'];

$post = BlogPost::get($id);

echo json_encode($post);