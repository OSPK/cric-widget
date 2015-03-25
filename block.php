<?php

echo "Your IP:" . $_SERVER['REMOTE_ADDR']."<br>";
if ($_SERVER['REMOTE_ADDR']=='104.236.65.135') {
	echo "This code appears if you are Mobilink";
}

else {
	echo "This code appears if you are Others";
}

?>