<?php

header("Access-Control-Allow-Origin: *");

require('../../helpers.php');
require('../../BlogCategoryController.php');

$categories = BlogCategoryController::all();

echo json_encode($categories);