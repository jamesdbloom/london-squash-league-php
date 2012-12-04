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

    public function create_matches($ignore_round_status = false)
    {
        foreach ($this->round_list as $round) {
            if ($ignore_round_status || $round->is_not_started()) {
                foreach ($this->divisions_in_league($round->league_id) as $division) {
                    foreach ($this->players_in_division($division) as $player_one) {
                        foreach ($this->players_in_division($division) as $player_two) {
                            if ($this->not_the_same_player($player_one, $player_two)) {
                                if ($this->no_match_already_exists($round, $player_one, $player_two)) {
                                    $this->match_list[] = MatchDAO::create($player_one->id, $player_two->id, $round->id, $division->id);
                                }
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

    public function matches_by_division_id()
    {
        $matches_by_division_id = array();
        foreach ($this->division_list as $division) {
            $matches_in_round = array();
            foreach ($this->match_list as $match) {
                if ($match->division_id == $division->id) {
                    $matches_in_round[] = $match;
                }
            }
            $matches_by_division_id[$division->id] = $matches_in_round;
        }
        return $matches_by_division_id;
    }

    public $players_by_division_id = array();

    public function players_by_division_id($division_id)
    {
        if (count($this->players_by_division_id) <= 0) {
            foreach ($this->division_list as $division) {
                $players_in_division = array();
                foreach ($this->player_list as $player) {
                    if ($player->division_id == $division->id && $player->is_active()) {
                        $players_in_division[] = $player;
                    }
                }
                $this->players_by_division_id[$division->id] = $players_in_division;
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