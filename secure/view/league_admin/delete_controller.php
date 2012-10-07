<?php
include '../admin/league_imports.php';

$club_id = Parameters::read_post_input('club_id');
$league_id = Parameters::read_post_input('league_id');
$division_id = Parameters::read_post_input('division_id');
$round_id = Parameters::read_post_input('round_id');
$match_id = Parameters::read_post_input('match_id');
$player_id = Parameters::read_post_input('player_id');

if (!empty($club_id)) {
    ClubDAO::delete_by_id($club_id);
}
if (!empty($league_id)) {
    LeagueDAO::delete_by_id($league_id);
}
if (!empty($division_id)) {
    DivisionDAO::delete_by_id($division_id);
}
if (!empty($round_id)) {
    RoundDAO::delete_by_id($round_id);
}
if (!empty($match_id)) {
    MatchDAO::delete_by_id($match_id);
}
if (!empty($player_id)) {
    PlayerDAO::delete_by_id($player_id);
}

Footer::outputFooter();
?>