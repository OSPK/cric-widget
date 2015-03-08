<?php
$server = $_SERVER['HTTP_HOST'];
$api = "http://". $server . "/api.php";

$allurl = $api;

if (isset($_GET['id'])) {
	$matchid = $_GET['id'];
	$matchurl = $api . "?id=$matchid";
}

function match_content() {
	global $api, $matchid, $matchurl;

	if (!isset($matchid)) {
		match_form();
	}

	if (isset($matchid)) {
		$json = file_get_contents($matchurl);
		$obj = json_decode($json);

		match_form();
		echo "<br>";

		if (is_array($obj)) {
			foreach ($obj as $match) {
				echo "<h1 class='title'>$match->si</h1><br>";
				echo "<h2 class='score'>$match->de</h2>";
				echo "<a class='refresh' href='javascript:location.reload(true)'><img width='30px' src='/assets/reload.png'><strong>Refresh</strong></a>";
			}
		}
	}
}

function match_form() {

	global $api, $matchid, $allurl;

	$json = file_get_contents($allurl);
	$obj = json_decode($json);
	$obj = array_reverse($obj);
	//$obj = array_slice($obj, 0,4);

	echo "<form action='/' method='GET' role='form'>";
	echo "<div class='styled-select'><select onchange='this.form.submit()'' name='id'>";
	if (is_array($obj)) {
		foreach ($obj as $match) {
			echo "<span class='hidden'>" . $match->id . "</span>";
			echo "<option value='$match->id'";
			if ($match->id==$matchid) {echo "selected";}
			echo ">" . $match->t1 . " vs " . $match->t2. "</option>";
		}
	}
	echo "</select></div></form>";
}