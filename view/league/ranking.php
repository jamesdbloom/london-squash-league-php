<?php
require_once('../../load.php');

$user = Session::get_user(true);

if (!empty($user)) {

    load::load_file('domain/ranking', 'rankingDAO.php');
    load::load_file('domain/round', 'roundDAO.php');
    load::load_file('domain/league', 'leagueDAO.php');
    load::load_file('domain/club', 'clubDAO.php');
    load::load_file('view/league_admin', 'league_data.php');

    Page::header(Link::Ranking);

    print "<p class='message'>This page displays the ranking for the current round for each league on a scale from 0 to 100.  The ranking is calculated based on how many matches you win, draw and loose.  More details will follow soon showing how this ranking is calculated and how the ranking is used to determine which division you will be in.</p>";
    $leagueData = new LeagueData();
    foreach (RoundDAO::get_all() as $round) {
        $league = LeagueDAO::get_by_id($round->league_id);
        if ($league_name != $league->name) {
            print "<div class='page_break'></div>";
            $league_name = $league->name;
            print "<h2 class='table_subtitle'>" . ClubDAO::get_by_id($league->club_id)->name . " &rsaquo; " . $league->name . "</h2>";
        }

        $rankings = $leagueData->calculate_ranking($round->id);
        if (!empty($rankings)) {
            print "<p class='table_message'>" . $round->name . "</p>";
            print "<table>";
            print "<tr><th class='player'>Player</th><th class='division'>Current Division</th><th class='score'>Points</th></tr>";
            foreach ($rankings as $ranking) {
                print "<tr><td class='player'>$ranking->name</td><td class='division'>$ranking->division</td><td class='score'>$ranking->relative_position</td></tr>";
            }
            print "</table>";
        } else {
            print "<p class='table_message no_print'>" . $round->name . "</p>";
            print "<p class='message'>no scores entered for this round yet</p>";
        }
    }

    Page::footer();

}
?>
