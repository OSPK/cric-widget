<?php 
 $server = $_SERVER['HTTP_HOST'];

 $url = "http://". $server . "/data/livedetail.json";
 $json = file_get_contents($url);
 $obj = json_decode($json);

?>
	<div id="widcontent">
			<?php 

				class ScoreBoard
				{
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

						//PLAYERS
						//TEAM A
						$this->players_a = array();
						foreach ($this->team_a->squad as $player) {
							$pid = $player->i;
							$this->players_a[$pid] = $player->short;
						}
						//TEAM B
						$this->players_b = array();
						foreach ($this->team_b->squad as $player) {
							$pid = $player->i;
							$this->players_b[$pid] = $player->short;
						}

						//SCORES
						//TEAM A
						$playerscores = $this->team_a_score->d->a->t;
						$this->players_a_scores = array();
						foreach ($playerscores as $playerscore) {
							$psid = $playerscore->i;
							$bat_score = "<strong>" . $playerscore->r . "</strong> (" . $playerscore->b . ") <span class='dism'>" . $playerscore->c . "</span>";
							$this->players_a_scores[$psid] = $bat_score;
						}
						//TEAM B
						$playerscores = $this->team_b_score->d->a->t;
						$this->players_b_scores = array();
						foreach ($playerscores as $playerscore) {
							$psid = $playerscore->i;
							$bat_score = "<strong>" . $playerscore->r . "</strong> (" . $playerscore->b . ") <span class='dism'>" . $playerscore->c . "</span>";
							$this->players_b_scores[$psid] = $bat_score;
						}

					}
					//END CONSTRUCTION

					public function teamname($team, $size='sn') {
						return $this->{$team}->{$size};
					}

					public function a_scores() {
						foreach ($this->players_a_scores as $id => $score) {
							echo "<div class='indv_scr'><span class='pname'>" . $this->players_a[$id] . '</span>';
							echo ": <span class='pscore'>" . $score . "</span><br></div>";
						}
					}

					public function b_scores() {
						foreach ($this->players_b_scores as $id => $score) {
							echo "<div class='indv_scr'><span class='pname'>" . $this->players_b[$id] . '</span>';
							echo ": <span class='pscore'>" . $score . "</span><br></div>";
						}
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

						echo "<span class='totalscore'>$total/$t_wkts ($t_ovrs) - SR $t_sr</span>";
					}

					public function bat_turn() {
						$a_turn = $this->team_a_score->s->i;
						$b_turn = $this->team_b_score->s->i;
						if ($a_turn == 1) {
							return "";
						}
					}
				}

				$scoreboard = new ScoreBoard($obj);

				echo "<div class='match-title big'><img src='".
				$scoreboard->place_img
				."'><br><br>".$scoreboard->place."<h1>".
				$scoreboard->teamname('team_b', 'fn').
				" <span>vs</span> ".
				$scoreboard->teamname('team_a', 'fn').
				"</h1><br><span class='live'>LIVE</span> <small>Refreshes automatically.</small></div>";

				echo "<div class='scrheadr'><span class='bigflag'>";$scoreboard->get_flag('team_a', 'std');echo "</span>";
				echo "<span class='teamfname'>" . $scoreboard->teamname('team_a', 'fn') . "</span></div>";
				$scoreboard->total_score('team_a_score');

				$scoreboard->a_scores();

				echo "<br><div class='mobile'>";
					$scoreboard->total_score('team_a_score');
				echo "</div><br>";

				if ($obj->query->count == 0) {
					echo "<p>Waiting for match...</p>";
				}

				echo "<div class='scrheadr'><span class='bigflag'>";$scoreboard->get_flag('team_b', 'std');echo "</span>";
				echo "<span class='teamfname'>" . $scoreboard->teamname('team_b', 'fn') . "</span></div>";
				$scoreboard->total_score('team_b_score');

				$scoreboard->b_scores();

				echo "<br><div class='mobile'>";
					$scoreboard->total_score('team_b_score');
				echo "</div><br>";

			?>
			<br><br>
	</div>

	<?php if ($obj->query->count==1) { ?>
			<script>
				document.title = "<?php if (isset($pagetitle)) {echo $pagetitle;}?>";
			</script>
	<?php } ;?>