<?php
require_once('../../load.php');
load::load_file('view/league_admin', 'league_imports.php');
load::load_file('view/admin', 'abstract_data.php');

class LeagueData extends AbstractData
{
    public $club_list;
    public $league_list;
    public $division_list;
    public $round_list;
    public $match_list;
    public $player_list;
    public $user_list;

    public $club_map;
    public $league_map;
    public $division_map;
    public $round_map;
    public $match_map;
    public $player_map;
    public $user_map;

    public $player_by_user_id_map;

    const name_spacer = " &rsaquo; ";

    public function __construct()
    {
        $this->club_list = ClubDAO::get_all();
        $this->league_list = LeagueDAO::get_all();
        $this->division_list = DivisionDAO::get_all();
        $this->round_list = RoundDAO::get_all();
        $this->match_list = MatchDAO::get_all();
        $this->player_list = PlayerDAO::get_all();
        $this->user_list = UserDAO::get_all();

        $this->club_map = $this->list_to_map($this->club_list);
        $this->league_map = $this->list_to_map($this->league_list);
        $this->division_map = $this->list_to_map($this->division_list);
        $this->round_map = $this->list_to_map($this->round_list);
        $this->match_map = $this->list_to_map($this->match_list);
        $this->player_map = $this->list_to_map($this->player_list);
        $this->user_map = $this->list_to_map($this->user_list);

        $this->player_by_user_id_map = $this->list_to_map($this->player_list, 'user_id');
    }

    public function print_club_name($club_id)
    {
        $club = $this->club_map[$club_id];
        $result = "&nbsp;";
        if (!empty($club)) {
            $result = $club->name;
        } else if (!empty($club_id)) {
            $result = $club_id;
        }
        return $result;
    }

    public function print_league_name($league_id)
    {
        $league = $this->league_map[$league_id];
        $result = "&nbsp;";
        if (!empty($league)) {
            $result = $this->print_club_name($league->club_id) . self::name_spacer . $league->name;
        } else if (!empty($league_id)) {
            $result = $league_id;
        }
        return $result;
    }

    public function print_division_name($division_id)
    {
        $division = $this->division_map[$division_id];
        $result = "&nbsp;";
        if (!empty($division)) {
            $result = $this->print_league_name($division->league_id) . self::name_spacer . $division->name;
        } else if (!empty($division_id)) {
            $result = $division_id;
        }
        return $result;
    }

    public function print_round_name($round_id, $fully_qualified = true, $spacer = self::name_spacer)
    {
        $round = $this->round_map[$round_id];
        $result = "&nbsp;";
        if (!empty($round)) {
            $result = ($fully_qualified ? $this->print_division_name($round->division_id) . $spacer : "") . $round->name;
        } else if (!empty($round_id)) {
            $result = $round_id;
        }
        return $result;
    }

    public function print_user_name($player_id, $fully_qualified = true)
    {
        $player = $this->player_map[$player_id];
        $user = $this->user_map[$player->user_id];
        $result = "N/A";
        if (!empty($user)) {
            $result = ($fully_qualified ? $this->print_division_name($player->division_id) . self::name_spacer : "") . $user->name;
        } else if (!empty($user_id)) {
            $result = $user_id;
        }
        return $result;
    }

    public function print_match_name($match_id, $fully_qualified = true, $spacer = self::name_spacer)
    {
        $match = $this->match_map[$match_id];
        $player_one = $this->player_map[$match->player_one_id];
        $player_two = $this->player_map[$match->player_two_id];
        if (!empty($match)) {
            $result = ($fully_qualified ? $this->print_round_name($match->round_id, true, $spacer) . $spacer : "") . self::print_user_name($player_one->id, false) . " vs " . self::print_user_name($player_two->id, false);
        } else {
            $result = $match_id;
        }
        return $result;
    }

    public function create_matches()
    {
        foreach ($this->round_list as $round) {
            if ($round->is_not_started()) {
                foreach ($this->players_in_division($round) as $player_one) {
                    foreach ($this->players_in_division($round) as $player_two) {
                        if ($this->not_the_same_player($player_one, $player_two)) {
                            if ($this->no_match_already_exists($round, $player_one, $player_two)) {
                                $this->match_list[] = MatchDAO::create($player_one->id, $player_two->id, $round->id);
                            }
                        }
                    }
                }
            }
        }
    }

    public function no_match_already_exists(Round $round, Player $player_one, Player $player_two)
    {
        $result = true;
        foreach ($this->match_list as $match) {
            if (
                $match->round_id == $round->id
                &&
                (
                    ($match->player_one_id == $player_one->id && $match->player_two_id == $player_two->id)
                    ||
                    ($match->player_one_id == $player_two->id && $match->player_two_id == $player_one->id)
                )
            ) {
                $result = false;
            }
        }
        return $result;
    }

    public function not_the_same_player(Player $player_one, Player $player_two)
    {
        return $player_one->id != $player_two->id;
    }

    public function players_in_division(Round $round)
    {
        $players_in_division = array();
        foreach ($this->player_list as $player) {
            if ($player->division_id == $round->division_id) {
                $players_in_division[] = $player;
            }
        }
        return $players_in_division;
    }

    public function leagues_without_round()
    {
        $leagues_without_round = array();
        foreach ($this->league_list as $league) {
            $has_round = false;
            foreach ($this->division_list as $division) {
                foreach ($this->round_list as $round) {
                    if ($round->division_id == $division->id && $division->league_id == $league->id) {
                        $has_round = true;
                    }
                }
            }
            if (!$has_round) {
                $leagues_without_round[] = $league;
            }
        }
        return $leagues_without_round;
    }

    public function rounds_in_league($league_id)
    {
        $rounds_in_league = array();
        foreach ($this->round_list as $round) {
            $division = $this->division_map[$round->division_id];
            $league = $this->league_map[$division->league_id];
            if ($league->id == $league_id) {
                $rounds_in_league[] = $round;
            }
        }
        return $rounds_in_league;
    }

    public function divisions_in_league($league_id)
    {
        $divisions_in_league = array();
        foreach ($this->division_list as $division) {
            $league = $this->league_map[$division->league_id];
            if ($league->id == $league_id) {
                $divisions_in_league[] = $division;
            }
        }
        return $divisions_in_league;
    }

    public function sort_and_filter_rounds($rounds, $finished = 'false')
    {
        $sorted_filtered_rounds = array();
        foreach (($finished == 'true' ? array(Round::finished) : array(Round::inplay, Round::starting_soon)) as $status) {
            foreach ($rounds as $round) {
                if ($round->status == $status) {
                    $sorted_filtered_rounds[] = $round;
                }
            }
        }
        return $sorted_filtered_rounds;
    }

    public function user_is_player_in_match($user_id, $match_id)
    {
        if (!empty($user_id) && !empty($match_id)) {
            $match = $this->match_map[$match_id];
            $player_one = $this->player_map[$match->player_one_id];
            $player_two = $this->player_map[$match->player_two_id];
            if (!empty($match) && !empty($player_one) && !empty($player_two)) {
                if ($user_id == $player_one->user_id || $user_id == $player_two->user_id) {
                    return true;
                }
            }
        }
        return false;
    }
}

?>