<?php 
$server = $_SERVER['HTTP_HOST'];

$url = "http://". $server . "/data/live.json";
$json = file_get_contents($url);
$obj = json_decode($json);

?>
<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="refresh" content="10; url=http://<?php echo $server . '/2.php'; ?>">
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
	<body <?php if ($obj->query->count==1) {echo "onload='parent.document.title=document.title'";} ?>>
		<div class="widheader"><strong>Live Score - Daily Pakistan Cricket</strong></div>
		<section class="widget">
			<?php 

				if ($obj->query->count==1) {
					
					$scores = $obj->query->results->Scorecard;

					$result = $scores->result;

					$a_team = $scores->teams[0];
					$b_team = $scores->teams[1];

					$a_id = $a_team->i;
					$b_id = $b_team->i;

					${$a_id} = $a_team->fn;
					${$b_id} = $b_team->fn;

					$flag_a = $a_team->flag; $logo_a = $a_team->logo;
					$flag_b = $b_team->flag; $logo_b = $b_team->logo;

					echo "<div class='match-title'>";
						echo "<img src='$flag_b->std'> <span class='h1'>" . $b_team->fn . " <br><strong>vs</strong><br> " . $a_team->fn . "</span> <img src='$flag_a->std'><br>";	
						echo "<br><span class='status'>$scores->ms</span><br><br>";
					echo "</div>";

					if (is_array($scores->past_ings)) {
						$the_scores_a = $scores->past_ings[0];
						$the_scores_b = $scores->past_ings[1];
					}
					$the_scores_a = $scores->past_ings;
					
					//Score for Team A
					$scorecard_a = $the_scores_a->s->a->r . "/" . $the_scores_a->s->a->w . " ("
						. $the_scores_a->s->a->o . ") ";
					echo "<img src='$flag_a->roundsmall'> ";
					echo $a_team->fn . ": <span class='score'>" . $scorecard_a . "</span>";

					echo "<br><br>";
					//Score for Team B
					$scorecard_b = $the_scores_b->s->a->r . "/" . $the_scores_b->s->a->w . " ("
						. $the_scores_b->s->a->o . ") ";
					echo "<img src='$flag_b->roundsmall'> ";
					echo $b_team->fn . ": <span class='score'>" . $scorecard_b . "</span>";

					if (isset($result->winner)) {
						echo "<br><br><h2 class='h2'><strong>${$result->winner}</strong> WON the match by $result->by $result->how </h2>";
					}							
					
					if ($the_scores_a->s->stay_live=='Yes') {
						$pagetitle = $a_team->sn . " " . $scorecard_a;
					}

					if ($the_scores_b->s->stay_live=='Yes') {
						$pagetitle = $b_team->sn . " " . $scorecard_b;
					}

				}

				elseif ($obj->query->count==0) {

					echo "<h2>Upcoming Matches</h2>";

					$url = "http://". $server . "/data/matches.json";
					$json = file_get_contents($url);				
					$obj = json_decode($json);
					$matches = $obj->query->results->Match;
					
					$our_id = 0;
					foreach ($matches as $match) {
						$team0 = $match->Team[0];
						$team1 = $match->Team[1];
						$gotdate = strtotime($match->StartDate)+10*60*60;
						$date = date('H:iA d M', $gotdate);
						echo $team1->Team . " vs " . $team0->Team . "<br>
						<span class='date'>$date</span><br><br>
						";
						$our_id++;
					}
				}
			?>
		</section>

		<!-- jQuery -->
		<!--script src="//code.jquery.com/jquery.js"></script-->
		<?php if ($obj->query->count==1) { ?>
			<script>
				document.title = "<?php if (isset($pagetitle)) {echo $pagetitle;}?>";
			</script>
		<?php } ;?>

		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-59742796-1', 'auto');
		  ga('send', 'pageview');

		</script>
	</body>
</html>