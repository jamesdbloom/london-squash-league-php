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
    $round = RoundDAO::get_by_id(Parameters::read_post_input('round_id'));
    DivisionDAO::create(
        $round->league_id,
        Parameters::read_post_input('round_id'),
        Parameters::read_post_input('name')
    );
}
if ($type == 'round') {
    RoundDAO::create(
        Parameters::read_post_input('league_id'),
        Parameters::read_post_input('start'),
        Parameters::read_post_input('end')
    );
}
if ($type == 'match') {
    MatchDAO::create(
        Parameters::read_post_input('player_one_id'),
        Parameters::read_post_input('player_two_id'),
        Parameters::read_post_input('round_id'),
        Parameters::read_post_input('division_id')
    );
}
if ($type == 'create_all_matches') {
    $leagueData = new LeagueData();
    $leagueData->create_matches(Parameters::read_post_input('ignore_round_status'));
}
if ($type == 'player') {
    PlayerDAO::create(
        Parameters::read_post_input('user_id'),
        Parameters::read_post_input('division_id'),
        Parameters::read_post_input('status')
    );
}

Footer::outputLeagueAdminFooter();
?>