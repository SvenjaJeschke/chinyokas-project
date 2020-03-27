<?php

header("Access-Control-Allow-Origin: *");

require('../../controllers/PlaylistController.php');

$urls = PlaylistController::urls();

echo json_encode($urls);