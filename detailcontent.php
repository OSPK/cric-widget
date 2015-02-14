<?php 
 $server = $_SERVER['HTTP_HOST'];

 $url = "http://". $server . "/data/full-scr.json";
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
					
					function __construct($obj) {

						$scorecard = $obj->query->results->Scorecard;

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
							$bat_score = $playerscore->r . " (" . $playerscore->b . ") " . $playerscore->c;
							$this->players_a_scores[$psid] = $bat_score;
						}
						//TEAM B
						$playerscores = $this->team_b_score->d->a->t;
						$this->players_b_scores = array();
						foreach ($playerscores as $playerscore) {
							$psid = $playerscore->i;
							$bat_score = $playerscore->r . " (" . $playerscore->b . ") " . $playerscore->c;
							$this->players_b_scores[$psid] = $bat_score;
						}

					}

					public function a_scores() {
						foreach ($this->players_a_scores as $id => $score) {
							echo $this->players_a[$id];
							echo " : " . $score . "<br>";
						}
					}

					public function b_scores() {
						foreach ($this->players_b_scores as $id => $score) {
							echo $this->players_b[$id];
							echo " : " . $score . "<br>";
						}
					} 
				}

				$scoreboard = new ScoreBoard($obj);

				$scoreboard->a_scores();
				echo "<br><br>";
				$scoreboard->b_scores();

			?>
	</div>

	<?php if ($obj->query->count==1) { ?>
			<script>
				document.title = "<?php if (isset($pagetitle)) {echo $pagetitle;}?>";
			</script>
	<?php } ;?>