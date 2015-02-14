<?php 
$server = $_SERVER['HTTP_HOST'];

$url = "http://". $server . "/data/live.json";
$json = file_get_contents($url);
$obj = json_decode($json);

if ($obj->query->count > 0) {
	$scores = $obj->query->results->Scorecard;
}

?>
	<?php 
		if ($obj->query->count > 0 && is_array($scores)) {
			include_once "doublecontent.php";
		}
		else {
			include_once "singlecontent.php";
		}
	?>