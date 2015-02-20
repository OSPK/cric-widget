<?php
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

		$scorecard = $obj;

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
?>