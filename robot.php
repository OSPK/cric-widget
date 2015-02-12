<?php
if (isset($_GET['write'])=='go') {

	$url = "https://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20FROM%20cricket.upcoming_matches%20WHERE%20series_id%3D%2211737%22&format=json&env=store%3A%2F%2F0TxIGQMQbObzvU4Apia0V0&callback=";
	$json = file_get_contents($url);
	$obj = json_decode($json);

	$file = fopen("matches.json","w");
	echo fwrite($file,$json);
	fclose($file);
	echo "<br>Written to matches.json: <br><pre>";
	print_r($obj); echo "</pre><br><br>";
					
	echo "======================================================<br>==============<br>=======";
	$matches = $obj->query->results->Match;

	$our_id = 0;
	foreach ($matches as $match) {
		$m_id = $match->matchid;
		echo "<br>ID: ". $m_id . "<br>";
		$url_m = "https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20cricket.scorecard.summary%20where%20match_id%3D$m_id&format=json&env=store%3A%2F%2F0TxIGQMQbObzvU4Apia0V0&callback=";
		$json_m = file_get_contents($url_m);
		$obj_m = json_decode($json_m);
		$filename = $our_id . ".json";
		$file_m = fopen($filename,"w");
		echo fwrite($file_m,$json_m);
		fclose($file_m);
		echo "<br>Written to $our_id.json: <br><pre>";
		print_r($obj_m); echo "</pre><br><br>";
		$our_id++;
		echo "=======================<br>==============<br>=======";
	}

}

else {
	echo "Good";
}

?>