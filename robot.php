<?php 
$server = $_SERVER['HTTP_HOST'];
if (isset($_GET['write'])) {$this_write='write=' . $_GET['write'];} else {$this_write=null;}
?>
<meta http-equiv="refresh" content="10; url=http://<?php echo $server . '/robot.php?' . $this_write; ?>" />
<?php
if (isset($_GET['write'])=='go') {

	$url = "https://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20FROM%20cricket.upcoming_matches%20WHERE%20series_id%3D%2211737%22&format=json&env=store%3A%2F%2F0TxIGQMQbObzvU4Apia0V0&callback=";
	$json = file_get_contents($url);
	$obj = json_decode($json);

	$file = fopen("data/matches.json","w");
	echo fputs($file,$json);
	echo '<br>'. $file;
	fclose($file);
	echo "</pre><br><br>";
					
	echo "======================================================<br>==============<br>=======";
	

	$url_m = "https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20cricket.scorecard.live.summary&format=json&env=store%3A%2F%2F0TxIGQMQbObzvU4Apia0V0&callback=";
	$json_m = file_get_contents($url_m);
	$obj_m = json_decode($json_m);
	$filename = "data/live.json";
	$file_m = fopen($filename,"w");
	echo fputs($file_m,$json_m);
	echo '<br>'. $file_m;
	fclose($file_m);
	echo "</pre><br><br>";

	echo "=======================<br>==============<br>=======";

	$url_m = "https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20cricket.scorecard.live&format=json&env=store%3A%2F%2F0TxIGQMQbObzvU4Apia0V0&callback=";
	$json_m = file_get_contents($url_m);
	$obj_m = json_decode($json_m);
	$filename = "data/livedetail.json";
	$file_m = fopen($filename,"w");
	echo fputs($file_m,$json_m);
	echo '<br>'. $file_m;
	fclose($file_m);
	echo "</pre><br><br>";

	echo "ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS 
	ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS 
	ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS ENDS";

}

else {
	echo "Good";
}

?>