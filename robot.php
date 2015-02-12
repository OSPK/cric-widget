<?php
$url = "https://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20FROM%20cricket.upcoming_matches%20WHERE%20series_id%3D%2211737%22&format=json&env=store%3A%2F%2F0TxIGQMQbObzvU4Apia0V0&callback=";
$json = file_get_contents($url);

$file = fopen("matches.json","w");
echo fwrite($file,$json);
fclose($file);

?>