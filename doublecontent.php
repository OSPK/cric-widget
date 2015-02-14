<?php 

$server = $_SERVER['HTTP_HOST'];

$url = "http://". $server . "/data/live.json";
$json = file_get_contents($url);
$obj = json_decode($json);

?>
	<div id="widcontent" style="overflow-y:scroll;">
			<?php 

				$scoreses = $obj->query->results->Scorecard;

				foreach ($scoreses as $scores) {

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


					$the_scores_a = $scores->past_ings;

					if (is_array($scores->past_ings)) {
						$the_scores_a = $scores->past_ings[1];
						$the_scores_b = $scores->past_ings[0];
					}

					echo "<div class='scorecard'>";					
						//Score for Team A
						$scorecard_a = $the_scores_a->s->a->r . "/" . $the_scores_a->s->a->w . " ("
							. $the_scores_a->s->a->o . ") ";
						echo "<img src='$flag_a->roundsmall'> ";
						echo $a_team->fn . ": <span class='score'>" . $scorecard_a . "</span>";

						echo "<br><br>";
						//Score for Team B
						$scorecard_b = $the_scores_b->s->a->r . "/" . $the_scores_b->s->a->w . " ("
							. $the_scores_b->s->a->o . ") ";
						if ($the_scores_b->s->a->r=='') {
							$scorecard_b = 'Bowling';
						}
						echo "<img src='$flag_b->roundsmall'> ";
						echo $b_team->fn . ": <span class='score'>" . $scorecard_b . "</span>";
					echo "</div>";

					if (isset($result->winner)) {
						echo "<br><br><h2 class='h2'><strong>${$result->winner}</strong> WON the match by $result->by $result->how </h2>";
					}							
					
					if ($the_scores_a->s->stay_live=='Yes') {
						$pagetitle = $a_team->sn . " " . $scorecard_a;
					}

					if ($the_scores_b->s->stay_live=='Yes') {
						$pagetitle = $b_team->sn . " " . $scorecard_b;
					}

					echo "<br><br>";
				}
			?>
	</div>