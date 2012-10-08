<?php
require_once('../../load.php');
load::load_file('view/admin', 'league_imports.php');
load::load_file('view/league_admin', 'league_data.php');

class AccountData extends LeagueData
{
    public $user;

    public function __construct()
    {
        $this->user = Session::get_user();
        if (!empty($this->user)) {
            $this->club_list = ClubDAO::get_all_by_user_id($this->user->id);
            $this->league_list = LeagueDAO::get_all_by_user_id($this->user->id);
            $this->division_list = DivisionDAO::get_all_by_user_id($this->user->id);
            $this->round_list = RoundDAO::get_all_by_user_id($this->user->id);
            $this->match_list = MatchDAO::get_all_by_user_id($this->user->id);
            $this->player_list = PlayerDAO::get_all_by_user_id($this->user->id);
            $this->user_list = array($this->user);

            $this->club_map = $this->list_to_map($this->club_list);
            $this->league_map = $this->list_to_map($this->league_list);
            $this->division_map = $this->list_to_map($this->division_list);
            $this->round_map = $this->list_to_map($this->round_list);
            $this->player_map = $this->list_to_map(PlayerDAO::get_all());
            $this->user_map = $this->list_to_map(UserDAO::get_all());
        } else {
            $GLOBALS['errors']->add('not_logged_in', 'You are not logged in');
        }
    }
}

?>