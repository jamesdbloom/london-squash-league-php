<?php
include '../admin/league_header.php';
require_once('../admin/league_footer.php');

$club_id = Parameters::read_post_input('club_id');
$league_id = Parameters::read_post_input('league_id');
$division_id = Parameters::read_post_input('division_id');
$round_id = Parameters::read_post_input('round_id');
if (!empty($club_id)) {
    ClubDAO::delete_by_id($club_id, $errors);
}
if (!empty($league_id)) {
    LeagueDAO::delete_by_id($league_id, $errors);
}
if (!empty($division_id)) {
    DivisionDAO::delete_by_id($division_id, $errors);
}
if (!empty($round_id)) {
    RoundDAO::delete_by_id($round_id, $errors);
}

Footer::outputFooter($errors);
?>