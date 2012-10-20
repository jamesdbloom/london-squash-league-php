<?php
require_once('../../load.php');
load::load_file('view/league_admin', 'league_imports.php');
load::load_file('view/league_admin', 'league_data.php');

$type = Parameters::read_post_input('type');
if ($type == 'club') {
    ClubDAO::create(
        Parameters::read_post_input('name'),
        Parameters::read_post_input('address')
    );
}
if ($type == 'league') {
    LeagueDAO::create(
        Parameters::read_post_input('club_id'),
        Parameters::read_post_input('name')
    );
}
if ($type == 'division') {
    DivisionDAO::create(
        Parameters::read_post_input('league_id'),
        Parameters::read_post_input('name')
    );
}
// todo - remove type 'round' as no longer used
if ($type == 'round') {
    RoundDAO::create(
        Parameters::read_post_input('division_id'),
        Parameters::read_post_input('start'),
        Parameters::read_post_input('end')
    );
}
if ($type == 'all_rounds_for_league') {
    $divisions = DivisionDAO::get_all_by_league_id(Parameters::read_post_input('league_id'));
    foreach ($divisions as $division) {
        RoundDAO::create(
            $division->id,
            Parameters::read_post_input('start'),
            Parameters::read_post_input('end')
        );
    }
}
if ($type == 'match') {
    MatchDAO::create(
        Parameters::read_post_input('player_one_id'),
        Parameters::read_post_input('player_two_id'),
        Parameters::read_post_input('round_id')
    );
}
if ($type == 'create_all_matches') {
    $leagueData = new LeagueData();
    $leagueData->create_matches();
}
if ($type == 'player') {
    PlayerDAO::create(
        Parameters::read_post_input('user_id'),
        Parameters::read_post_input('division_id')
    );
}

Footer::outputFooter();
?>