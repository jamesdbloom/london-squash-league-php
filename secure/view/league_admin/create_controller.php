<?php
include '../admin/league_imports.php';

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
if ($type == 'round') {
    RoundDAO::create(
        Parameters::read_post_input('division_id'),
        Parameters::read_post_input('start'),
        Parameters::read_post_input('end')
    );
}
if ($type == 'match') {
    MatchDAO::create(
        Parameters::read_post_input('player_one_id'),
        Parameters::read_post_input('player_two_id'),
        Parameters::read_post_input('round_id')
    );
}
if ($type == 'player') {
    PlayerDAO::create(
        Parameters::read_post_input('user_id'),
        Parameters::read_post_input('division_id')
    );
}

Footer::outputFooter();
?>