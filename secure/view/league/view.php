<?php
require_once('../../load.php');

$user = Session::get_user(true);

if (!empty($user)) {

    load::load_file('view/admin', 'form_output.php');
    load::load_file('view/league_admin', 'league_data.php');

    $leagueData = new LeagueData();

    $league_id = Parameters::read_request_input('league_id');
    $finished = Parameters::read_request_input('finished', 'false');

    $message = Parameters::read_request_input('message');
    if ($message == 'only_match_players') {
        $GLOBALS['errors']->add('only_match_players', 'Only the players in a match can enter the score');
    } else if ($message == 'no_match_selected') {
        $GLOBALS['errors']->add('no_match_selected', 'To enter a score please select a match from the matches table below', Error::message);
    }

    Page::header(Link::Leagues);

    if (empty($league_id)) {
        print "<div class='message'>";
        print "<div class='table_message'>Choose a league to only display matches for that league</div>";
        print "<form method='get' action='view.php'>";
        print "<div class='select_league_form'>";
        print "<div><select name='league_id'>";
        if (count($leagueData->league_list) > 0) {
            foreach ($leagueData->league_list as $league) {
                print "<option value='" . $league->id . "''>" . $leagueData->print_league_name($league->id) . "</option>\n";
            }
        }
        print "</select></div>";
        print "<input type='hidden' name='finished' value='$finished' />";
        print "<div><input class='submit' type='submit' value='select'></div>";
        print "&nbsp;</div>";
        print "</form>";
        print "</div>";
    } else {
        print "<h2 class='table_title'>" . $leagueData->print_league_name($league_id) . "</h2>";
        print "<div class='standalone_link'><a href='view.php?finished=$finished'>Show all leagues and divisions</a></div>";
    }
    if (empty($message)) {
        if ($finished == 'true') {
            print "<div class='standalone_link'><a href='view.php?" . (!empty($league_id) ? "league_id=$league_id&" : "") . "finished=false'>Show in play and soon to start rounds</a></div>";
        } else {
            print "<div class='standalone_link'><a href='view.php?" . (!empty($league_id) ? "league_id=$league_id&" : "") . "finished=true'>Show finished rounds</a></div>";
        }
    }

    // DIVISIONS
    print_table_start('Divisions', '');
    print "<tr><th class='league'>Club</th><th class='league'>League</th><th class='division'>Division</th></tr>";
    print "<p class='table_message'>Click on a row to jump to the table for that division</p>";
    $divisions = (empty($league_id) ? $leagueData->division_list : $leagueData->divisions_in_league($league_id));
    foreach ($divisions as $division) {
        $league = $leagueData->league_map[$division->league_id];
        print_table_row(
            array('club', 'league', 'division'), array(
                "<a class='league_internal_page_link' href='#$division->id' >" . $leagueData->club_map[$league->club_id]->name . "</a>",
                "<a class='league_internal_page_link' href='#$division->id' >" . $league->name . "</a>",
                "<a class='league_internal_page_link' href='#$division->id' >" . $division->name . "</a>")
        );
    }
    print "</table>";

    // MATCHES
    print "<h2 class='table_title'>Matches</h2>";
    $rounds = $leagueData->sort_and_filter_rounds((empty($league_id) ? $leagueData->round_list : $leagueData->rounds_in_league($league_id)), $finished);
    $start_date = '';
    foreach ($rounds as $round) {
        if ($start_date != $round->start) {
            print "<p class='table_subtitle'>" . (empty($league_id) ? $leagueData->print_league_name($leagueData->division_map[$round->division_id]->league_id) : "") . " " . $round->name . "</p>";
            $start_date = $round->start;
        }
        print_table_start($leagueData->print_division_name($round->division_id), '', 'table_message', $round->division_id);
        print "<tr><th class='player'>Player One</th><th class='player'>Player Two</th><th class='score'>Score</th></tr>";
        foreach ($leagueData->match_list as $match) {
            if ($match->round_id == $round->id) {
                $score = $match->score;
                if (empty($score)
                    &&
                    $leagueData->user_is_player_in_match($user->id, $match->id)
                    && $leagueData->round_in_play($match->id)
                ) {
                    $score = Link::get_link(Link::Enter_Score, false, 'enter')->add_query_string('match_id=' . $match->id);
                }
                print_table_row(
                    array('player', 'player', 'score'),
                    array($leagueData->print_user_name($match->player_one_id, false), $leagueData->print_user_name($match->player_two_id, false), $score)
                );
            }
        }
        print "</table>";
    }

    Page::footer();

} else {

    Page::not_logged_in();

}
?>
