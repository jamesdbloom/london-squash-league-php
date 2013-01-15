<?php
require_once('../../load.php');
load::load_file('view/league_admin', 'league_imports.php');
load::load_file('view/league_admin', 'league_data.php');

$type = Parameters::read_post_input('type');
if ($type == 'club') {
    ClubDAO::update(
        Parameters::read_post_input('id'),
        Parameters::read_post_input('name'),
        Parameters::read_post_input('address')
    );
}
if ($type == 'league') {
    LeagueDAO::update(
        Parameters::read_post_input('id'),
        Parameters::read_post_input('club_id'),
        Parameters::read_post_input('name')
    );
}
if ($type == 'division') {
    DivisionDAO::update(
        Parameters::read_post_input('id'),
        Parameters::read_post_input('league_id'),
        Parameters::read_post_input('round_id'),
        Parameters::read_post_input('name')
    );
}
if ($type == 'round') {
    RoundDAO::update(
        Parameters::read_post_input('id'),
        Parameters::read_post_input('league_id'),
        Parameters::read_post_input('start'),
        Parameters::read_post_input('end')
    );
}
if ($type == 'player') {
    PlayerDAO::update_status_by_id(
        Parameters::read_post_input('id'),
        Parameters::read_post_input('status')
    );
}

Footer::outputLeagueAdminFooter();
?>