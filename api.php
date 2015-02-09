<?php
$api = "http://cricscore-api.appspot.com/csa";

$url = $api;

if (isset($_GET['id'])) {
	$matchid = $_GET['id'];
	$url = $api . "?id=$matchid";
}

$json = file_get_contents($url);
echo $json;