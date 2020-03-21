<?php

header("Access-Control-Allow-Origin: *");

require('../../helpers.php');
require('../../BlogCategory.php');

$categories = BlogCategory::all();

echo json_encode($categories);