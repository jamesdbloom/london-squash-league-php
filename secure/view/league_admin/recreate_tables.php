<?php
include '../admin/league_header.php';
require_once('../admin/league_footer.php');

DivisionDAO::create_division_schema($errors);
LeagueDAO::create_league_schema($errors);
ClubDAO::create_club_schema($errors);

Footer::outputFooter($errors);
?>