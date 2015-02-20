<?php 
// $server = $_SERVER['HTTP_HOST'];

// $url = "http://". $server . "/data/live.json";
// $json = file_get_contents($url);
// $obj = json_decode($json);

?>
	<div id="widcontent">
			<?php 

				if ($obj->query->count > 0) {
					
						class ScoreBoard {

						public $team_a;
						public $team_b;

						public $team_a_score;
						public $team_b_score;

						public $players_a;
						public $players_b;

						public $players_a_scores;
						public $players_b_scores;

						public $bat_status;

						public $place;
						public $place_img;
						
						function __construct($obj) {

							if ($obj->query->count == 1) {
								$scorecard = $obj->query->results->Scorecard;
							}
							if ($obj->query->count > 1) {
								$scorecard = $obj->query->results->Scorecard[0];
							}
							
							$this->place = $scorecard->place->stadium;
							$this->place_img = $scorecard->place->Gimaget;

							$this->team_a = $scorecard->teams[0];
							$this->team_b = $scorecard->teams[1];

							//ASSOCIATE SCORES WITH TEAMS
							if (is_array($scorecard->past_ings)) {
								$ing0 = $scorecard->past_ings[0];
								$ing1 = $scorecard->past_ings[1];

								if ( $ing0->s->a->i == $this->team_a->i) {
									$this->team_a_score = $ing0;
									$this->team_b_score = $ing1;
								}

								else {
									$this->team_a_score = $ing1;
									$this->team_b_score = $ing0;
								}
							}

							else {
								$ing0 = $scorecard->past_ings;

								if ( $ing0->s->a->i == $this->team_a->i) {
									$this->team_a_score = $ing0;
								}

								else {
									$this->team_b_score = $ing0;
								}
							}
							//END

						}
						//END CONSTRUCTION

						public function teamname($team, $size='sn') {
							return $this->{$team}->{$size};
						}

						public function get_flag($team, $size) {
							$thisteam = $this->{$team};
							echo "<img src='" . $thisteam->flag->{$size} . "'>";
						}

						public function total_score($team) {
							$total = $this->{$team}->s->a->r;
							$t_wkts = $this->{$team}->s->a->w;
							$t_ovrs = $this->{$team}->s->a->o;
							$t_sr = $this->{$team}->s->a->cr;

							return "<span class='score'>$total/$t_wkts ($t_ovrs) - SR $t_sr</span>";
						}

					}

					$scoreboard = new ScoreBoard($obj);

					echo "<div class='match-title'>";
					$scoreboard->get_flag('team_b', 'std');
						echo "<span class='h1'>" . $scoreboard->teamname('team_b', 'fn') . " <br><strong>vs</strong><br> " . $scoreboard->teamname('team_a', 'fn') . "</span>";
					$scoreboard->get_flag('team_a', 'std'); echo "<br>";
						echo "<br><span class='live'>LIVE</span> <small>Refreshes automatically.</small><br><br>";
					echo "</div><br>";

					echo "<div class='scorecard'>";	

					$scoreboard->get_flag('team_a', 'roundsmall');
					echo " " . $scoreboard->teamname('team_a', 'sn') . "----";

					$team_a_scr = $scoreboard->total_score('team_a_score');

					if ($team_a_scr=="<span class='score'>/ () - SR </span>") {
						echo "Bowling...";
					} else { echo $team_a_scr; }

					echo "<br><br>";

					$scoreboard->get_flag('team_b', 'roundsmall');
					echo " ".$scoreboard->teamname('team_b', 'sn') . "----";

					$team_b_scr = $scoreboard->total_score('team_b_score');
					
					if ($team_b_scr=="<span class='score'>/ () - SR </span>") {
						echo "Bowling...";
					} else { echo $team_b_scr; }

					echo "</div'>";	



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