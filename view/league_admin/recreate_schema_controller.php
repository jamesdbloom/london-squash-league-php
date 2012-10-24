<?php
require_once('../../load.php');
load::load_file('view/league_admin', 'league_imports.php');

if (Parameters::read_post_input('yes') == 'yes') {

    PlayerDAO::create_player_schema();
    MatchDAO::create_match_schema();
    RoundDAO::create_round_schema();
    DivisionDAO::create_division_schema();
    LeagueDAO::create_league_schema();
    ClubDAO::create_club_schema();

    Footer::outputFooter();

} else {

    Headers::set_redirect_header(Link::Recreate_Tables);

}
?>