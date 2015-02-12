<?php 
include_once "2functions.php";
?>
<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Cric Widget</title>
		<!--CSS -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400' rel='stylesheet' type='text/css'>
		<link href="assets/style.css" rel="stylesheet">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<section>
			<?php 
			if (!isset($_GET['match'])) {
				$url = "https://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20FROM%20cricket.upcoming_matches%20WHERE%20series_id%3D%2211737%22&format=json&env=store%3A%2F%2F0TxIGQMQbObzvU4Apia0V0&callback=";
				$json = file_get_contents($url);
				$obj = json_decode($json);
				$matches = $obj->query->results->Match;
				//$obj = array_slice($obj, 0,4);
				foreach ($matches as $match) {
					$team0 = $match->Team[0];
					$team1 = $match->Team[1];
					$gotdate = strtotime($match->StartDate)+5*60*60;
					$date = date('m-d H:i meridan', $gotdate);
					echo "$date <br>
					<span>  </span>
					<a href='?match=$match->matchid'>" . $team0->Team . " vs " . $team1->Team . '</a><br>';
				}
			}

			if (isset($_GET['match'])) {
					$m_id = $_GET['match']; 
					$url = "https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20cricket.scorecard.summary%20where%20match_id%3D$m_id&format=json&env=store%3A%2F%2F0TxIGQMQbObzvU4Apia0V0&callback=";
					$json = file_get_contents($url);
					$obj = json_decode($json);
					$scores = $obj->query->results->Scorecard;
					//$obj = array_slice($obj, 0,4);

					$a_team = $scores->teams[0];
					$flag = $a_team->flag;
					echo "<img src='$flag->roundsmall'> " . $a_team->fn . " ";
					
			}		



			?>
		</section>

		<!-- jQuery -->
		
		</script>
	</body>
</html>