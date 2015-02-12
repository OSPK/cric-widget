<?php
$server = $_SERVER['HTTP_HOST'];

$url = "http://". $server . "/data/matches.json";
$json = file_get_contents($url);				
$obj = json_decode($json);
echo "<h1>MATCHES</h1>";
echo "<br>======================================================================================<br><pre>";
print_r($obj);
echo "<h1>## END MATCHES ##</h1>";
echo "<br>======================================================================================<br><pre>";

$numbers = [0,1,2,3,4];

foreach ($numbers as $number) {

	$url = "http://". $server . "/data/$number.json";
	$json = file_get_contents($url);				
	$obj = json_decode($json);
	echo "<h1>$number</h1>";
	echo "<br>======================================================================================<br><pre>";
	print_r($obj);
	echo "<h1>## END $number ##</h1>";
	echo "<br>======================================================================================<br><pre>";


} 
?>