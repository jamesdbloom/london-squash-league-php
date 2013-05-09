<?php
require_once('../../load.php');

if (Session::is_administrator()) {

    load::load_file('view/admin', 'form_output.php');
    load::load_file('view/league_admin', 'league_data.php');

    $leagueData = new LeagueData();
    Page::header(Link::League_Admin, array(), '', '', array(Link::get_link(Link::League_Admin_Recreate_Tables)));

    // CLUBS
    print_table_start('Clubs', 'action_table');
    print "<tr><th class='db_id'>Id</th><th class='club'>Name</th><th class='address'>Address</th><th class='button_column last'></th></tr>";
    foreach ($leagueData->club_list as $club) {
        print_form_with_modify(
            Link::root . Link::League_Admin_Delete_Controller_Url,
            array('db_id', 'club', 'address'), array($club->id, $club->name, $club->address),
            array('club_id'), array($club->id),
            Link::League_Admin_Modify_Club_Url, $club->id
        );

    }
    print_create_form_start(Link::root . Link::League_Admin_Create_Controller_Url, 'club');
    print "<tr class='create_row'><td class='db_id last'></td><td class='club last'><input class='show_validation' name='name' type='text' pattern='.{3,25}' required='required'></td><td class='address last'><input name='address' type='text' pattern='.{10,125}'></td><td class='button_column last'><input type='submit' name='create' value='create'></td></tr>";
    print_form_table_end();

    // LEAGUES
    print_table_start('Leagues', 'action_table');
    print "<tr><th class='db_id'>Id</th><th class='club'>Club</th><th class='league'>League</th><th class='button_column last'></th></tr>";
    foreach ($leagueData->league_list as $league) {
        print_form_with_modify(
            Link::root . Link::League_Admin_Delete_Controller_Url,
            array('db_id', 'club', 'league'), array($league->id, $leagueData->print_club_name($league->club_id), $league->name),
            array('league_id'), array($league->id),
            Link::League_Admin_Modify_League_Url, $league->id
        );
    }
    print_create_form_start(Link::root . Link::League_Admin_Create_Controller_Url, 'league');
    print "<tr class='create_row'><td class='db_id last'></td><td class='club last'>";
    if (count($leagueData->club_list) > 0) {
        print "<select name='club_id'>";
        foreach ($leagueData->club_list as $club) {
            print "<option value='" . $club->id . "''>$club->name</option>";
        }
        print "</select>";
    } else {
        print "&nbsp;";
    }
    print "</td><td class='league last'><input class='show_validation' name='name' type='text' pattern='.{3,25}' required='required'></td><td class='button_column last'><input type='submit' name='create' value='create'></td></tr>";
    print_form_table_end();

    // ROUNDS
    print_table_start('Rounds', 'action_table');
    print "<tr><th class='db_id'>Id</th><th class='division'>League</th><th class='status hide_on_small_screen'>Status</th><th class='date'>Start</th><th class='date'>End</th><th class='button_column last'></th></tr>";
    foreach ($leagueData->round_list as $round) {
        print_form_with_modify(
            Link::root . Link::League_Admin_Delete_Controller_Url,
            array('db_id', 'division', 'status hide_on_small_screen', 'date', 'date'), array($round->id, $leagueData->print_league_name($round->league_id), $round->status, date('d-M-Y', $round->start), date('d-M-Y', $round->end)),
            array('round_id'), array($round->id),
            Link::League_Admin_Modify_Round_Url, $round->id
        );
    }
    $leagues = $leagueData->league_list;
    if (count($leagues) > 0) {
        print_create_form_start(Link::root . Link::League_Admin_Create_Controller_Url, 'round');
        print "<tr class='create_row'><td class='db_id last'></td><td class='division last'>";
        print "<select name='league_id'>";
        foreach ($leagues as $league) {
            print "<option value='" . $league->id . "''>" . $leagueData->print_league_name($league->id) . "</option>";
        }
        print "</select>";
        print "</td><td class='status last hide_on_small_screen'>&nbsp;</td><td class='date last'><input name='start' type='date' required='required'/></td><td class='date last'><input name='end' type='date' required='required'/></td><td class='button_column last'><input type='submit' name='create' value='create'></td></tr>";
        print "</form>";
    }
    print "</table>";

    // DIVISIONS
    print_table_start('Divisions', 'action_table');
    print "<tr><th class='db_id'>Id</th><th class='league'>League</th><th class='round'>Round</th><th class='division'>Division</th><th class='button_column last'></th></tr>";
    foreach ($leagueData->division_list as $division) {
        print_form_with_modify(
            Link::root . Link::League_Admin_Delete_Controller_Url,
            array('db_id', 'league', 'round', 'division'), array($division->id, $leagueData->print_league_name($division->league_id), $leagueData->print_round_name($division->round_id, false), $division->name),
            array('division_id'), array($division->id),
            Link::League_Admin_Modify_Division_Url, $division->id
        );
    }
    print_create_form_start(Link::root . Link::League_Admin_Create_Controller_Url, 'division');
    print "<tr class='create_row'><td class='db_id last'></td><td class='round last' colspan='2'>";
    if (count($leagueData->league_list) > 0) {
        print "<select name='round_id'>";
        foreach ($leagueData->round_list as $round) {
            print "<option value='" . $round->id . "''>" . $leagueData->print_round_name($round->id) . "</option>";
        }
        print "</select>";
    } else {
        print "&nbsp;";
    }
    print "</td><td class='division last'><input class='show_validation' name='name' type='text' pattern='.{1,25}' required='required'></td><td class='button_column last'><input type='submit' name='create' value='create'></td></tr>";
    print_form_table_end();

    // PLAYERS
    $number_of_players = 0;
    print_table_start('Players', 'action_table');
    print "<tr><th class='db_id'>Id</th><th class='division'>Division</th><th class='name'>User</th><th class='status'>Status</th><th class='button_column last'></th></tr>";
    foreach ($leagueData->player_list as $player) {
        print_form_with_modify(
            Link::root . Link::League_Admin_Delete_Controller_Url,
            array('db_id', 'division', 'name', 'status'), array($player->id, $leagueData->print_division_name($player->division_id), $leagueData->print_user_name($player->id, false, '', true), $player->status),
            array('player_id'), array($player->id),
            Link::League_Admin_Modify_Player_Url, $player->id
        );
        if ($player->id > $number_of_players) {
            $number_of_players = $player->id;
        }
    }
    print_create_form_start(Link::root . Link::League_Admin_Create_Controller_Url, 'player');
    print "<tr class='create_row'><td class='db_id last'></td><td class='division last'>";
    if (count($leagueData->division_list) > 0) {
        print "<select name='division_id'>";
        foreach ($leagueData->division_list as $division) {
            print "<option value='" . $division->id . "''>" . $leagueData->print_division_name($division->id) . "</option>";
        }
        print "</select>";
    } else {
        print "&nbsp;";
    }
    print "</td><td class='name last'>";
    if (count($leagueData->user_list) > 0) {
        print "<select name='user_id'>";
        foreach ($leagueData->user_list as $user) {
            print "<option value='" . $user->id . "''>" . $user->name . "</option>";
        }
        print "</select>";
    } else {
        print "&nbsp;";
    }
    print "</td><td class='status last'>";
    print "<select name='status'>";
    print "<option value='" . Player::active . "''>" . Player::active . "</option>";
    print "<option value='" . Player::inactive . "''>" . Player::inactive . "</option>";
    print "</select>";
    print "</td><td class='button_column last'><input type='submit' name='create' value='create'></td></tr>";
    print_form_table_end();

    print "<p class='num_of_players'>Number of Players: $number_of_players</p>";

    // MATCHES
    print "<h2 class='table_title'>Matches</h2>";
    foreach ($leagueData->round_list as $round_table) {
        foreach ($leagueData->divisions_in_round($round_table->id) as $division) {
            print_table_start($leagueData->print_division_name($division->id), 'action_table', 'table_subtitle');
            print "<tr><th class='round'>Round</th><th class='player'>Player One</th><th class='player'>Player Two</th><th class='score'>Score</th><th class='score_entered hide_on_medium_screen'>Score Entered</th><th class='button_column last'></th></tr>";
            foreach ($leagueData->matches_by_division_id[$division->id] as $match) {
//                if ($match->round_id == $round_table->id) {
                    print_form(
                        Link::root . Link::League_Admin_Delete_Controller_Url,
                        array('round', 'player', 'player', 'score', 'score_entered hide_on_medium_screen'), array($leagueData->print_round_name($match->round_id, false), $leagueData->print_user_name($match->player_one_id, false), $leagueData->print_user_name($match->player_two_id, false), $match->score, $match->score_entered_date),
                        array('match_id'), array($match->id)
                    );
//                }
            }
            print_create_form_start(Link::root . Link::League_Admin_Create_Controller_Url, 'match');
            print "<tr><td class='db_id last'></td><td class='round last'>";
            if (count($leagueData->round_list) > 0) {
                print "<select name='round_id'>";
                foreach ($leagueData->round_list as $round) {
                    if ($round->id == $round_table->id) {
                        print "<option value='" . $round->id . "''>" . $leagueData->print_round_name($round->id, false) . "</option>";
                    }
                }
                print "</select>";
            } else {
                print "&nbsp;";
            }
            print "</td><td class='player last'>";
            $players_in_division = $leagueData->players_in_division($division);
            if (count($players_in_division) > 0) {
                print "<select name='player_one_id'>";
                foreach ($players_in_division as $player) {
                    print "<option value='" . $player->id . "''>" . $leagueData->print_user_name($player->id, false) . "</option>";
                }
                print "</select>";
            } else {
                print "&nbsp;";
            }
            print "</td><td class='player last'>";
            if (count($players_in_division) > 0) {
                print "<select name='player_two_id'>";
                foreach ($players_in_division as $player) {
                    print "<option value='" . $player->id . "''>" . $leagueData->print_user_name($player->id, false) . "</option>";
                }
                print "</select>";
            } else {
                print "&nbsp;";
            }
            print "</td><td class='score last'></td><td class='score_entered hide_on_medium_screen last'></td><td class='button_column last'><input type='submit' name='create' value='create'></td></tr>";
            print_form_table_end();
        }
    }

// commented ability to create matches separately from creating a new round

//    print "<h2 class='table_title'>Create All Matches</h2>";
//    print_create_form_start(Link::root . Link::League_Admin_Create_Controller_Url, 'create_all_matches');
//    print "<div class='create_all_matches_form'>";
//    print "<p><label class='ignore_round_status' for='ignore_round_status'>Ignore Round Status:</label><input id='ignore_round_status' name='ignore_round_status' type='checkbox' /></p>";
//    print "<p class='submit'><input class='submit' type='submit' name='create' value='create'></p>";
//    print "</div></form><br/>";

// commented code below is idea to make outputting tables simpler and less code

//print choose_players($listViewData, 'player_two_id', 'print_user_name');

//function choose_players(LeagueData $leagueData, $field_id, $callback)
//{
//    if (count($leagueData->user_list) > 0) {
//        print "<select name='" . $field_id . "'>";
//        foreach ($leagueData->player_list as $player) {
//            print "<option value='" . $player->id . "''>" . call_user_func(array($leagueData, $callback), $player->user_id) . "</option>";
//        }
//        print "</select>";
//    } else {
//        print "&nbsp;";
//    }
//}

    Page::footer();

} else {

    Page::not_authorised();

}

?>