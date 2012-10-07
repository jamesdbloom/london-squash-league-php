<?php
include '../admin/league_imports.php';

PlayerDAO::create_player_schema();
MatchDAO::create_match_schema();
RoundDAO::create_round_schema();
DivisionDAO::create_division_schema();
LeagueDAO::create_league_schema();
ClubDAO::create_club_schema();

Footer::outputFooter();
?>