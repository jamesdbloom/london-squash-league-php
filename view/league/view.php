<?php
require_once('../../load.php');

$user = Session::get_user(true);

if (!empty($user)) {

    load::load_file('view/admin', 'form_output.php');
    load::load_file('view/account', 'account_data.php');


    $league_id = Parameters::read_request_input('league_id');
    $finished = Parameters::read_request_input('finished', 'false');
    $print_league = (Parameters::read_request_input('print') === 'true' && $user->is_league_manager());

    if ($print_league) {
        $leagueData = new LeagueData();
        $league_list = $leagueData->league_list;
        $division_list = $leagueData->division_list;
        $round_list = $leagueData->round_list;
    } else {
        $leagueData = new AccountData();
        $league_list = $leagueData->user_league_list;
        $division_list = $leagueData->user_division_list;
        $round_list = $leagueData->user_round_list;
    }

    $message = Parameters::read_request_input('message');
    if ($message == 'only_match_players') {
        $GLOBALS['errors']->add('only_match_players', 'Only the players in a match can enter the score');
    } else if ($message == 'no_match_selected') {
        $GLOBALS['errors']->add('no_match_selected', 'To enter a score please select a match from the matches table below', Error::message);
    }

    Page::header(($print_league ? Link::Print_League : Link::League), array(), ($finished != 'true' ? 'in play rounds' : 'finished rounds'));

    if (!$print_league) {
        if (empty($league_id)) {
            print "<div class='message'>";
            print "<div class='table_message'>This page shows the divisions you are playing in, to view all divisions in one of your leagues select a league:</div>";
            print "<form method='get' action='" . Link::root . Link::League_Url . "'>";
            print "<div class='select_league_form'>";
            print "<div class='select'><select name='league_id'>";
            if ($print_league && !empty($league_id)) {
                print "<option value='''>All Leagues</option>\n";
            }
            if (count($league_list) > 0) {
                foreach ($league_list as $league) {
                    print "<option value='" . $league->id . "''>" . $leagueData->print_league_name($league->id) . "</option>\n";
                }
            }
            print "</select></div>";
            print "<input type='hidden' name='print' value='" . ($print_league ? 'true' : 'false') . "' />";
            print "<input type='hidden' name='finished' value='$finished' />";
            print "<div><input class='submit' type='submit' value='select'></div>";
            print "&nbsp;</div>";
            print "</form>";
            print "</div>";
        } else {
            print "<div class='standalone_link'><a href='" . Link::root . Link::League_Url . "?finished=$finished'>Show only your divisions</a></div>";
        }
        if (empty($message)) {
            if ($finished == 'true') {
                print "<div class='standalone_link'><a href='" . Link::root . Link::League_Url . "?" . (!empty($league_id) ? "league_id=$league_id&" : "") . ($print_league ? 'print=true&' : '') . "finished=false'>Show in-play <span class='hide_on_very_small_screen'>and imminent </span>rounds</a></div>";
            } else {
                print "<div class='standalone_link'><a href='" . Link::root . Link::League_Url . "?" . (!empty($league_id) ? "league_id=$league_id&" : "") . ($print_league ? 'print=true&' : '') . "finished=true'>Show finished rounds</a></div>";
            }
        }

        // DIVISIONS
        if (empty($league_id)) {
            print "<h2 class='table_title'>Your Divisions</h2>";
        } else {
            print "<h2 class='table_title'>" . $leagueData->print_league_name($league_id) . "</h2>";
        }
        print "<table>";
        print "<tr><th class='league'>Club</th><th class='league'>League</th><th class='division'>Division</th></tr>";
        print "<p class='table_message'>Click on a row to jump to the matches for that division</p>";
        $divisions = (empty($league_id) ? $division_list : $leagueData->divisions_in_league($league_id));
        foreach ($divisions as $division) {
            $league = $leagueData->league_map[$division->league_id];
            print_table_row(
                array('club', 'league', 'division'),
                array(
                    "<a class='league_internal_page_link' href='#" . $division->id . "_small' >" . $leagueData->club_map[$league->club_id]->name . "</a>",
                    "<a class='league_internal_page_link' href='#" . $division->id . "_small' >" . $league->name . "</a>",
                    "<a class='league_internal_page_link' href='#" . $division->id . "_small' >" . $division->name . "</a>"
                ), "td", 'small_screen'
            );
        }
        foreach ($divisions as $division) {
            $league = $leagueData->league_map[$division->league_id];
            print_table_row(
                array('club', 'league', 'division'),
                array(
                    "<a class='league_internal_page_link' href='#" . $division->id . "_large' >" . $leagueData->club_map[$league->club_id]->name . "</a>",
                    "<a class='league_internal_page_link' href='#" . $division->id . "_large' >" . $league->name . "</a>",
                    "<a class='league_internal_page_link' href='#" . $division->id . "_large' >" . $division->name . "</a>"
                ), "td", 'large_screen'
            );
        }
        print "</table>";
    }

    // MATCHES
    $rounds = $leagueData->sort_and_filter_rounds((empty($league_id) ? $round_list : $leagueData->rounds_in_league($league_id)), $finished);
    $start_date = '';
    $end_date = '';

    $matches_by_division_id = $leagueData->matches_by_division_id();
    foreach ($rounds as $round) {
        $divisions_in_league = (empty($league_id) ? $leagueData->divisions_in_league($round->league_id, $division_list) : $leagueData->divisions_in_league($league_id));
        foreach ($divisions_in_league as $division) {
            if ($start_date != $round->start && $end_date != $round->end) {
                print "<p class='table_subtitle'>" . $round->name . "</p>";
                $start_date = $round->start;
                $end_date = $round->end;
            }

            $players_by_division_id = $leagueData->players_by_division_id($division->id);

            if (count($players_by_division_id) > 0) {
                // small screen - start
                print_table_start($leagueData->print_division_name($division->id), 'small_screen', 'table_message small_screen', $division->id . "_small");
                print "<tr><th class='player'>Player One</th><th class='player'>Player Two</th><th class='score'>Score</th></tr>";
                foreach ($matches_by_division_id[$division->id] as $match) {
                    $score = $match->score;
                    if (empty($score)
                        && $leagueData->user_is_player_in_match($user->id, $match->id)
                        && $leagueData->round_in_play($match->id)
                        && !$print_league
                    ) {
                        $score = Link::get_link(Link::Enter_Score, false, 'enter')->add_query_string('match_id=' . $match->id);
                    }
                    print_table_row(
                        array('player', 'player', 'score'),
                        array($leagueData->print_user_name($match->player_one_id, false), $leagueData->print_user_name($match->player_two_id, false), $score)
                    );
                }
                print "</table>";
                // small screen - end

                // large screen - start
                print_table_start($leagueData->print_division_name($division->id), 'league large_screen', 'table_message large_screen', $division->id . "_large");
                print "<tr><th class='player'></th>";
                foreach ($players_by_division_id as $player_column) {
                    $matches_by_player_id = $leagueData->matches_by_player_id($player_column->id, $round->id);
                    if (count($matches_by_player_id) > 0) {
                        print "<th class='player'>" . $leagueData->print_user_name($player_column->id, false) . "</th>";
                    }
                }
                print "</tr>";
                foreach ($players_by_division_id as $player_row) {
                    $matches_by_player_id = $leagueData->matches_by_player_id($player_row->id, $round->id);
                    if (count($matches_by_player_id) > 0) {
                        print "<tr><td class='player'>" . $leagueData->print_user_name($player_row->id, false) . "</td>";
                        foreach ($players_by_division_id as $player_column) {
                            $matches_by_player_id = $leagueData->matches_by_player_id($player_column->id, $round->id);
                            if (count($matches_by_player_id) > 0) {
                                if ($player_row->id != $player_column->id) {
                                    $match_cell = $leagueData->match_by_player_ids($player_row->id, $player_column->id, $round->id);
                                    $score = $match_cell->score;
                                    if (!empty($score) && $match_cell->player_one_id == $player_column->id) {
                                        $score_parts = explode('-', $score);
                                        $score = $score_parts[1] . "-" . $score_parts[0];
                                    }
                                    if (empty($score)
                                        && $leagueData->user_is_player_in_match($user->id, $match_cell->id)
                                        && $leagueData->round_in_play($match_cell->id)
                                        && !$print_league
                                    ) {
                                        $score = Link::get_link(Link::Enter_Score, false, 'enter')->add_query_string('match_id=' . $match_cell->id);
                                    }
                                    print "<td class='score'>$score</td>";
                                } else {
                                    print "<td class='no_match'>X</td>";
                                }
                            }
                        }
                        print "</tr>";
                    }
                }
                print "</table>";
                // large screen - end
            }
        }
    }

    Page::footer();

}
?>
