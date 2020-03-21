<?php

header("Access-Control-Allow-Origin: *");

require('../Playlist.php');

$urls = Playlist::urls();

echo json_encode($urls);