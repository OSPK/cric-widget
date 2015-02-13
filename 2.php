<?php 
$server = $_SERVER['HTTP_HOST'];
$this_match = null;
if (isset($_GET['match'])) {$this_match='match=' . $_GET['match'];}

function exis($var) {

	if (isset($var)) {return $var;}
}
?>
<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php if (isset($_GET['match'])) { ?>
			<meta http-equiv="refresh" content="15; url=http://<?php echo $server . '/2.php?' . $this_match; ?>" />
		<?php } ?>
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
	<body <?php if (isset($_GET['match'])) {echo "onload='parent.document.title=document.title'";} ?>>
		<div class="widheader"><strong>Live Score - Daily Pakistan Cricket</strong></div>
		<section class="widget">
			<?php 
				if ( isset($_GET['yes']) || isset($_GET['match'])) {

					if (!isset($_GET['match'])) {
						$server = $_SERVER['HTTP_HOST'];
						$url = "http://". $server . "/data/matches.json";
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
							$url = "http://". $server . "/data/$m_id.json";
							$json = file_get_contents($url);
							$obj = json_decode($json);
							$scores = $obj->query->results->Scorecard;

							$a_team = $scores->teams[0];
							$b_team = $scores->teams[1];

							$a_id = $a_team->i;
							$b_id = $b_team->i;

							$flag_a = $a_team->flag;
							$flag_b = $b_team->flag;

							echo "<img src='$flag_a->roundsmall'> <span class='h1'>" . $a_team->fn . " <strong>vs</strong> " . $b_team->fn . "</span> <img src='$flag_b->roundsmall'><br><br>";	
							
							$the_scores_a = exis($scores->past_ings[0]);
							$the_scores_b = exis($scores->past_ings[1]);
							
							//Score for Team A
							$scorecard_a = $the_scores_a->s->a->r . "/" . $the_scores_a->s->a->w . " ("
								. $the_scores_a->s->a->o . ") ";
							echo "<img src='$flag_a->roundsmall'> ";
							echo $a_team->fn . ": " . $scorecard_a;

							echo "<br><br>";
							//Score for Team B
							$scorecard_b = $the_scores_b->s->a->r . "/" . $the_scores_b->s->a->w . " ("
								. $the_scores_b->s->a->o . ") ";
							echo "<img src='$flag_b->roundsmall'> ";
							echo $b_team->fn . ": " . $scorecard_b;
							



							$pagetitle = $a_team->sn;
					}
				}

				else {
					echo "<h1>Live Scores Starting Tomorrow</h1>";
					echo "<img width='70%' src='/assets/2015_Cricket_World_Cup_Logo.png'>";

				}
			?>
		</section>

		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<?php if (isset($_GET['match'])) { ?>
			<script>
				document.title = "<?php if (isset($pagetitle)) {echo $pagetitle;}?>";
			</script>
		<?php } ;?>
	</body>
</html>