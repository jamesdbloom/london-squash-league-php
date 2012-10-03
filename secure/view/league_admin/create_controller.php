<?php
include '../admin/league_header.php';
require_once('../admin/league_footer.php');

$type = Parameters::read_post_input('type');
if ($type == 'club') {
    ClubDAO::create(
        Parameters::read_post_input('name'),
        Parameters::read_post_input('address'),
        $errors
    );
}
if ($type == 'league') {
    LeagueDAO::create(
        Parameters::read_post_input('club_id'),
        Parameters::read_post_input('name'),
        $errors
    );
}
if ($type == 'division') {
    DivisionDAO::create(
        Parameters::read_post_input('league_id'),
        Parameters::read_post_input('name'),
        $errors
    );
}
if ($type == 'round') {
    RoundDAO::create(
        Parameters::read_post_input('division_id'),
        Parameters::read_post_input('start'),
        Parameters::read_post_input('end'),
        $errors
    );
}

Footer::outputFooter($errors);
?>