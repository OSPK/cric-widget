<?php 
$server = $_SERVER['HTTP_HOST'];
$this_match = null;
if (isset($_GET['match'])) {$this_match='match=' . $_GET['match'];}
?>
<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="refresh" content="10; url=http://<?php echo $server . '/2.php?' . $this_match; ?>" />
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
				$server = $_SERVER['HTTP_HOST'];
				$url = "http://". $server . "/matches.json";
				$json = file_get_contents($url);				
				$obj = json_decode($json);
				$matches = $obj->query->results->Match;
				
				$our_id = 0;
				foreach ($matches as $match) {
					$team0 = $match->Team[0];
					$team1 = $match->Team[1];
					$gotdate = strtotime($match->StartDate)-6*60*60;
					$date = date('H:ia d M', $gotdate);
					echo "<a href='?match=$our_id'>" . $team0->Team . " vs " . $team1->Team . "</a><br>
					<span class='date'>$date</span><br><br>
					";
					$our_id++;
				}
			}

			if (isset($_GET['match'])) {
					$m_id = $_GET['match']; 
					$server = $_SERVER['HTTP_HOST'];
					$url = "http://". $server . "/$m_id.json";
					$json = file_get_contents($url);
					$obj = json_decode($json);
					$scores = $obj->query->results->Scorecard;

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