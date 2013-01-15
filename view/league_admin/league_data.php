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
        $this->player_by_status_map = $this->list_to_map($this->player_list, 'status');
        $this->matches_by_division_id = $this->list_to_map($this->match_list, 'division_id');
        $this->matches_by_round_id = $this->list_to_map($this->match_list, 'round_id');
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
            $result = ($fully_qualified ? $this->print_league_name($round->league_id) . $spacer : "") . $round->name;
        } else if (!empty($round_id)) {
            $result = $round_id;
        }
        return $result;
    }

    public function print_user_name($player_id, $fully_qualified = true, $user_id = '', $show_contact_details = false)
    {
        $player = $this->player_map[$player_id];
        $user = $this->user_map[$player->user_id];
        $result = "N/A";
        if (!empty($user)) {
            $mobile = str_replace(' ', '&nbsp;', $user->mobile);
            $result = ($fully_qualified ?
                $this->print_division_name($player->division_id) . self::name_spacer :
                "") .
                ($user->id == $user_id
                    ? ' you '
                    : $user->name . ($show_contact_details ? ($user->mobile_privacy != User::secret && !empty($mobile) ? "<br/><a href='tel:$mobile'>$mobile<a/>" : "") . "<br/><a href='mailto:$user->email'><span class='hide_on_small_screen'>$user->email</span><span class='display_on_small_screen'>email</span><a/>" : ""));
        } else if (!empty($user_id)) {
            $result = $user_id;
        }
        return $result;
    }

    public function get_opponent_email($player_one_id, $player_two_id, $user_id)
    {
        $email = null;
        if ($player_one_id != $user_id) {
            $email = $this->user_map[$player_one_id]->email;
        } else if ($player_two_id != $user_id) {
            $email = $this->user_map[$player_two_id]->email;
        }
        return $email;
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

    public function print_player_one_name($match_id)
    {
        $match = $this->match_map[$match_id];
        $player_one = $this->player_map[$match->player_one_id];
        if (!empty($match)) {
            return self::print_user_name($player_one->id, false);
        }
        return '';
    }

    public function print_player_two_name($match_id)
    {
        $match = $this->match_map[$match_id];
        $player_two = $this->player_map[$match->player_two_id];
        if (!empty($match)) {
            return self::print_user_name($player_two->id, false);
        }
        return '';
    }

    public function print_opponents_mobile($match_id, $user_id)
    {
        $match = $this->match_map[$match_id];
        $player_one = $this->player_map[$match->player_one_id];
        $player_two = $this->player_map[$match->player_two_id];

        $opponent = null;
        if ($user_id == $player_one->user_id) {
            $opponent = $this->user_map[$player_two->user_id];
        } else if ($user_id == $player_two->user_id) {
            $opponent = $this->user_map[$player_one->user_id];
        }
        if (!empty($opponent) && $opponent->mobile_privacy != User::secret) {
            return $opponent->mobile;
        }
    }

    public function calculate_ranking($round_id)
    {
        $player_scores = array();
        $player_divisions = array();
        foreach ($this->matches_by_round_id[$round_id] as $match) {
            if (!empty($match->score)) {
                $division = $this->division_map[$match->division_id]->name;
                list($player_one_score, $player_two_score) = explode("-", $match->score);

                if ($player_one_score > $player_two_score) {
                    $player_one_match_points = 3 / $division + $player_one_score * 0.1;
                    $player_two_match_points = 1 / $division + $player_two_score * 0.1;
                } else if ($player_two_score > $player_one_score) {
                    $player_one_match_points = 1 / $division + $player_one_score * 0.1;
                    $player_two_match_points = 3 / $division + $player_two_score * 0.1;
                } else {
                    $player_one_match_points = 2 / $division + $player_one_score * 0.1;
                    $player_two_match_points = 2 / $division + $player_two_score * 0.1;
                }

                if (!empty($player_scores[$match->player_one_id])) {
                    $player_scores[$match->player_one_id] += $player_one_match_points;
                } else {
                    $player_scores[$match->player_one_id] = $player_one_match_points;
                }
                if (!empty($player_scores[$match->player_one_id])) {
                    $player_scores[$match->player_two_id] += $player_two_match_points;
                } else {
                    $player_scores[$match->player_two_id] = $player_two_match_points;
                }

                $player_divisions[$match->player_one_id] = $match->division_id;
                $player_divisions[$match->player_two_id] = $match->division_id;
            }
        }
        arsort($player_scores);
        reset($player_scores);
        $highest_score = current($player_scores);
        $rankings = array();
        foreach ($player_scores as $player_id => $points) {
            $player = $this->player_map[$player_id];
            $user = $this->user_map[$player->user_id];
            $division = $this->division_map[$player_divisions[$player_id]];
            $league = $this->league_list[$player->league_id];

            $rankings[] = new Ranking($player_id, $user->name, $user->email, $division->name, $league->name, $points, round(($points / $highest_score) * 100));
        }

        return $rankings;
    }

    public function create_divisions_for_new_round($round_id)
    {
        $new_round = $this->round_map[$round_id];
        $previous_end_date = strtotime(' -1 day', strtotime(date('d-M-Y', $new_round->start)));
        foreach ($this->round_list as $round) {
            if ($round->league_id == $new_round->league_id && date('d-M-Y', $round->end) == date('d-M-Y', $previous_end_date)) {
                $previous_round = $round;
                break;
            }
        }
        if (!empty($previous_round)) {
            $rankings = $this->calculate_ranking($previous_round->id);
            $ranking_map = $this->list_to_map($rankings, 'player_id');

            $numOfPlayers = 0;

            $active_league_players = array();
            foreach ($this->player_by_status_map[Player::active] as $active_player) {
                $ranking = $ranking_map[$active_player->id];
                if ($active_player->league_id == $new_round->league_id) {
                    $numOfPlayers++;
                    if (empty($ranking)) {
                        $active_league_players[] = $active_player;
                    }
                }
            }

            $player_order = array();
            foreach ($rankings as $ranking) {
                $player_order[] = $this->player_map[$ranking->player_id];
            }
            foreach ($active_league_players as $active_player) {
                $player_order[] = $active_player;
            }

            $divisions = array();
            $divisionSizeCharacteristics = DivisionSizeCharacteristics::calculationDivisionSizeCharacteristics($numOfPlayers);
            for ($division = 0; $division < $divisionSizeCharacteristics->noOfFullSizeDivisions; $division++) {
                $divisions[] = array_splice($player_order, 0, $divisionSizeCharacteristics->divisionSize);
            }
            for ($division = 0; $division < $divisionSizeCharacteristics->noOfSmallerDivisions; $division++) {
                $divisions[] = array_splice($player_order, 0, ($divisionSizeCharacteristics->divisionSize - 1));
            }

            foreach ($divisions as $index => $division_players) {
                $division_id = DivisionDAO::create($new_round->league_id, $round_id, ($index + 1));
                foreach ($division_players as $player) {
                    PlayerDAO::update_division_id($player->id, $division_id);
                }
                foreach ($division_players as $player_one) {
                    foreach ($division_players as $player_two) {
                        if ($this->not_the_same_player($player_one, $player_two)) {
                            if ($this->no_match_already_exists($new_round, $player_one, $player_two)) {
                                $this->match_list[] = MatchDAO::create($player_one->id, $player_two->id, $new_round->id, $division_id);
                            }
                        }
                    }
                }
            }
        }
    }

// commented ability to create matches separately from creating a new round

//    public function create_matches($ignore_round_status = false)
//    {
//        foreach ($this->round_list as $round) {
//            if ($ignore_round_status || $round->is_not_started()) {
//                foreach ($this->divisions_in_round($round->id) as $division) {
//                    foreach ($this->players_in_division($division) as $player_one) {
//                        foreach ($this->players_in_division($division) as $player_two) {
//                            if ($this->not_the_same_player($player_one, $player_two)) {
//                                if ($this->no_match_already_exists($round, $player_one, $player_two)) {
//                                    $this->match_list[] = MatchDAO::create($player_one->id, $player_two->id, $round->id, $division->id);
//                                }
//                            }
//                        }
//                    }
//                }
//            }
//        }
//    }

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

    public function players_in_division(Division $division)
    {
        $players_in_division = array();
        foreach ($this->player_list as $player) {
            if ($player->division_id == $division->id && $player->status == Player::active) {
                $players_in_division[] = $player;
            }
        }
        return $players_in_division;
    }

    public function rounds_in_league($league_id)
    {
        $rounds_in_league = array();
        foreach ($this->round_list as $round) {
            if ($round->league_id == $league_id) {
                $rounds_in_league[] = $round;
            }
        }
        return $rounds_in_league;
    }

    public function divisions_in_league($league_id, $division_list = null)
    {
        if (empty($division_list)) {
            $division_list = $this->division_list;
        }
        $divisions_in_league = array();
        foreach ($division_list as $division) {
            $league = $this->league_map[$division->league_id];
            if ($league->id == $league_id) {
                $divisions_in_league[] = $division;
            }
        }
        return $divisions_in_league;
    }

    public function divisions_in_round($round_id, $division_list = null)
    {
        if (empty($division_list)) {
            $division_list = $this->division_list;
        }
        $divisions_in_round = array();
        foreach ($division_list as $division) {
            if ($division->round_id == $round_id) {
                $divisions_in_round[] = $division;
            }
        }
        return $divisions_in_round;
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

    public function round_in_play($match_id)
    {
        $match = $this->match_map[$match_id];
        if (!empty($match)) {
            $round = $this->round_map[$match->round_id];
            if (!empty($round)) {
                return $round->is_inplay();
            }
        }
        return false;
    }

    public $players_by_division_id = array();

    public function players_by_division_id($division_id)
    {
        if (count($this->players_by_division_id) <= 0) {
            foreach ($this->division_list as $division) {
                if (!is_array($this->matches_by_division_id[$division->id])) {
                    $match = $this->matches_by_division_id[$division->id];
                    $this->players_by_division_id[$division->id][$match->player_one_id] = $this->player_map[$match->player_one_id];
                    $this->players_by_division_id[$division->id][$match->player_two_id] = $this->player_map[$match->player_two_id];
                } else {
                    foreach ($this->matches_by_division_id[$division->id] as $match) {
                        $this->players_by_division_id[$division->id][$match->player_one_id] = $this->player_map[$match->player_one_id];
                        $this->players_by_division_id[$division->id][$match->player_two_id] = $this->player_map[$match->player_two_id];
                    }
                }
            }
        }
        return $this->players_by_division_id[$division_id];
    }

    public $match_by_player_ids = array();

    public function match_by_player_ids($player_one_id, $player_two_id, $round_id)
    {
        if (count($this->match_by_player_ids) <= 0) {
            foreach ($this->match_list as $match) {
                $this->match_by_player_ids[$match->round_id . '->' . $match->player_one_id . '-' . $match->player_two_id] = $match;
            }
        }
        $result = $this->match_by_player_ids[$round_id . '->' . $player_one_id . '-' . $player_two_id];
        if (empty($result)) {
            $result = $this->match_by_player_ids[$round_id . '->' . $player_two_id . '-' . $player_one_id];
        }
        return $result;
    }

    public $matches_by_player_id = array();

    public function matches_by_player_id($player_id, $round_id)
    {
        if (count($this->matches_by_player_id) <= 0) {
            foreach ($this->match_list as $match) {
                $match_list_player_one = $this->matches_by_player_id[$match->round_id . '->' . $match->player_one_id];
                if (empty($match_list_player_one)) {
                    $match_list_player_one = array($match);
                } else {
                    $match_list_player_one[$match->id] = $match;
                }
                $this->matches_by_player_id[$match->round_id . '->' . $match->player_one_id] = $match_list_player_one;

                $match_list_player_two = $this->matches_by_player_id[$match->round_id . '->' . $match->player_two_id];
                if (empty($match_list_player_two)) {
                    $match_list_player_two = array($match);
                } else {
                    $match_list_player_two[] = $match;
                }
                $this->matches_by_player_id[$match->round_id . '->' . $match->player_two_id] = $match_list_player_two;
            }
        }
        return $this->matches_by_player_id[$round_id . '->' . $player_id];
    }
}

?>