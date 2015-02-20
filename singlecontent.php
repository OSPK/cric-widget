<?php 
// $server = $_SERVER['HTTP_HOST'];

// $url = "http://". $server . "/data/live.json";
// $json = file_get_contents($url);
// $obj = json_decode($json);
include_once "summary_class.php";
?>
	<div id="widcontent">
			<?php 

				if ($obj->query->count > 0) {

					$scoreboard = new ScoreBoard($scores);

					echo "<div class='match-title'>";
					$scoreboard->get_flag('team_b', 'std');
						echo "<span class='h1'>" . $scoreboard->teamname('team_b', 'fn') . " <br><strong>vs</strong><br> " . $scoreboard->teamname('team_a', 'fn') . "</span>";
					$scoreboard->get_flag('team_a', 'std'); echo "<br>";
						echo "<br><span class='live'>LIVE</span> <small>Refreshes automatically.</small><br><br>";
					echo "</div><br>";

					echo "<div class='scorecard'>";	

						$scoreboard->get_flag('team_a', 'roundsmall');
						echo " ".$scoreboard->teamname('team_a', 'sn');

						$team_a_scr = $scoreboard->total_score('team_a_score');

						if ($team_a_scr=="<span class='score'>/ () - SR </span>") {
							echo "<span class='rightt'>Bowling...</span>";
						} else { echo "<span class='rightt'>" .$team_a_scr. "</span>"; }

						echo "<br><br>";

						$scoreboard->get_flag('team_b', 'roundsmall');
						echo " ".$scoreboard->teamname('team_b', 'sn');

						$team_b_scr = $scoreboard->total_score('team_b_score');
						
						if ($team_b_scr=="<span class='score'>/ () - SR </span>") {
							echo "<span class='rightt'>Bowling...</span>";
						} else { echo "<span class='rightt'>" .$team_b_scr. "</span>"; }

					echo "</div>";	

				}

				elseif ($obj->query->count==0) {

					echo "<div class='schd'><h2 class='h2'><strong>Upcoming Matches</strong></h2><br><div class='upcoming'>";

					$url = "http://". $server . "/data/matches.json";
					$json = file_get_contents($url);				
					$obj = json_decode($json);
					$matches = $obj->query->results->Match;
					
					$our_id = 0;
					foreach ($matches as $match) {
						$team0 = $match->Team[0];
						$team1 = $match->Team[1];
						$gotdate = strtotime($match->StartDate);
						$date = date('H:iA d M', $gotdate);
						echo $team1->Team . " vs " . $team0->Team . "<br>
						<span class='date'>$date</span><br><br>
						";
						$our_id++;
					}

					echo "</div></div>";
				}
			?>
	</div>


	<script>
		document.title = "Scorecard Summary";
	</script>