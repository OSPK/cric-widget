<?php 

// $server = $_SERVER['HTTP_HOST'];

// $url = "http://". $server . "/data/live.json";
// $json = file_get_contents($url);
// $obj = json_decode($json);
include_once "summary_class.php";
?>
<style type="text/css">
	section	{
		overflow-y:scroll;
	}
</style>
		
		<div id="widcontent">
			<?php 

				$scoreses = $obj->query->results->Scorecard;

				$scoreses = array_reverse($scoreses);

				foreach ($scoreses as $scores) {

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

					echo "<div class='seper'><hr></div>";
				}
			?>
	</div>