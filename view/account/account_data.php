<?php
require_once('../../load.php');
load::load_file('view/league_admin', 'league_imports.php');
load::load_file('view/league_admin', 'league_data.php');

class AccountData extends LeagueData
{
    public $user;
    public $user_club_list;
    public $user_league_list;
    public $user_league_list_ignore_player_status;
    public $user_division_list;
    public $user_division_list_ignore_round_status;
    public $user_division_list_ignore_player_status;
    public $user_round_list;
    public $user_match_list;
    public $user_player_list;

    public $user_club_map;
    public $user_league_map;
    public $user_league_map_ignore_player_status;
    public $user_division_map;
    public $user_round_map;
    public $user_player_map;

    public $user_division_to_player_map;

    public function __construct()
    {
        parent::__construct();
        $user_id = Parameters::read_request_input('user_id');
        if (Session::is_administrator() && !empty($user_id)) {
            $this->user = UserDAO::get_by_id($user_id);
        } else {
            $this->user = Session::get_user();
        }
        if (!empty($this->user)) {
            $user_id = $this->user->id;
            $this->user_club_list = ClubDAO::get_all_by_user_id($user_id);
            $this->user_league_list = LeagueDAO::get_all_by_user_id($user_id);
            $this->user_league_list_ignore_player_status = LeagueDAO::get_all_by_user_id($user_id, true, true);
            $this->user_division_list = DivisionDAO::get_all_by_user_id($user_id);
            $this->user_division_list_ignore_round_status = DivisionDAO::get_all_by_user_id($user_id, false, true);
            $this->user_division_list_ignore_player_status = DivisionDAO::get_all_by_user_id($user_id, true, true);
            $this->user_round_list = RoundDAO::get_all_by_user_id($user_id);
            $this->user_match_list = MatchDAO::get_all_by_user_id($user_id);
            $this->user_player_list = PlayerDAO::get_all_by_user_id($user_id);

            $this->user_club_map = $this->list_to_map($this->user_club_list);
            $this->user_league_map = $this->list_to_map($this->user_league_list);
            $this->user_league_map_ignore_player_status = $this->list_to_map($this->user_league_list_ignore_player_status);
            $this->user_division_map = $this->list_to_map($this->user_division_list);
            $this->user_round_map = $this->list_to_map($this->user_round_list);
            $this->user_player_map = $this->list_to_map($this->user_player_list);

            $this->user_division_to_player_map = $this->list_to_map($this->user_player_list, 'division_id');
        } else {
            $GLOBALS['errors']->add('not_logged_in', 'You are not logged in');
        }
    }

    public function unregistered_leagues()
    {
        return array_diff($this->league_list, $this->user_league_list_ignore_player_status);
    }
}

?>