<?php
require_once('../../load.php');

$user = Session::get_user(true);

if (!empty($user)) {

    load::load_file('domain/ranking', 'rankingDAO.php');
    load::load_file('domain/league', 'leagueDAO.php');
    load::load_file('domain/club', 'clubDAO.php');

    Page::header(Link::Ranking);

    print "<p class='message'>This page displays the ranking for each league on a scale from 0 to 100.  The ranking is calculated based on how many matches you win, draw and loose.  More details will follow soon showing how this ranking is calculated and how the ranking is used to determine which division you will be in.</p>";
    foreach (LeagueDAO::get_all() as $league) {
        $rankings = RankingDAO::get_all_by_League($league->id);
        print "<h2 class='table_message'>" . ClubDAO::get_by_id($league->club_id)->name . " &rsaquo; " . $league->name . "</h2>";
        if (!empty($rankings)) {
            print "<table>";
            print "<tr><th class='player'>Player</th><th class='division'>Current Division</th><th class='score'>Points</th></tr>";
            foreach (RankingDAO::get_all_by_League($league->id) as $ranking) {
                print "<tr><td class='player'>$ranking->name</td><td class='division'>$ranking->division</td><td class='score'>$ranking->relative_position</td></tr>";
            }
            print "</table>";
        } else {
            print "<p class='table_title'>no scores entered for this round yet</p>";
        }
    }

    Page::footer();

}
?>
