<?php
require_once('../../load.php');

if (Session::is_administrator()) {

    load::load_file('view/admin', 'form_output.php');
    load::load_file('view/league_admin', 'league_data.php');

    $leagueData = new LeagueData();
    Page::header(Link::Leagues, array(), '', '', array(new Link('recreate_schema_controller.php', 'Recreate Table')));

    // CLUBS
    print_table_start('Clubs', 'action_table');
    print "<tr><th class='club'>Name</th><th class='address'>Address</th><th class='button last'></th></tr>\n";
    foreach ($leagueData->club_list as $club) {
        print_form(
            array('club', 'address'), array($club->name, $club->address),
            array('club_id'), array($club->id)
        );
    }
    print_create_form_start('club');
    print "<tr class='create_row'><td class='club last'><input class='show_validation' name='name' type='text' pattern='.{3,25}' required='required'></td><td class='address last'><input name='address' type='text' pattern='.{10,125}'></td><td class='button last'><input type='submit' name='create' value='create'></td></tr>\n";
    print_form_table_end();

    // LEAGUES
    print_table_start('Leagues', 'action_table');
    print "<tr><th class='club'>Club</th><th class='league'>League</th><th class='button last'></th></tr>\n";
    foreach ($leagueData->league_list as $league) {
        print_form(
            array('club', 'league'), array($leagueData->print_club_name($league->club_id), $league->name),
            array('league_id'), array($league->id)
        );
    }
    print_create_form_start('league');
    print "<tr class='create_row'><td class='club last'>";
    if (count($leagueData->club_list) > 0) {
        print "<select name='club_id'>";
        foreach ($leagueData->club_list as $club) {
            print "<option value='" . $club->id . "''>$club->name</option>\n";
        }
        print "</select>";
    } else {
        print "&nbsp;";
    }
    print "</td><td class='league last'><input class='show_validation' name='name' type='text' pattern='.{3,25}' required='required'></td><td class='button last'><input type='submit' name='create' value='create'></td></tr>\n";
    print_form_table_end();

    // DIVISIONS
    print_table_start('Divisions', 'action_table');
    print "<tr><th class='league'>League</th><th class='division'>Division</th><th class='button last'></th></tr>\n";
    foreach ($leagueData->division_list as $division) {
        print_form(
            array('league', 'division'), array($leagueData->print_league_name($division->league_id), $division->name),
            array('division_id'), array($division->id)
        );
    }
    print_create_form_start('division');
    print "<tr class='create_row'><td class='league last'>";
    if (count($leagueData->league_list) > 0) {
        print "<select name='league_id'>";
        foreach ($leagueData->league_list as $league) {
            print "<option value='" . $league->id . "''>" . $leagueData->print_league_name($league->id) . "</option>\n";
        }
        print "</select>";
    } else {
        print "&nbsp;";
    }
    print "</td><td class='division last'><input class='show_validation' name='name' type='text' pattern='.{3,25}' required='required'></td><td class='button last'><input type='submit' name='create' value='create'></td></tr>\n";
    print_form_table_end();

    // ROUNDS
    print_table_start('Rounds', 'action_table');
    print "<tr><th class='division'>Division</th><th class='date'>Start</th><th class='date'>End</th><th class='button last'></th></tr>\n";
    foreach ($leagueData->round_list as $round_table) {
        print_form(
            array('division', 'date', 'date'), array($leagueData->print_division_name($round_table->division_id), date('d-M-Y', $round_table->start), date('d-M-Y', $round_table->end)),
            array('round_id'), array($round_table->id)
        );
    }
    print_create_form_start('round');
    print "<tr class='create_row'><td class='division last'>";
    if (count($leagueData->division_list) > 0) {
        print "<select name='division_id'>";
        foreach ($leagueData->division_list as $division) {
            print "<option value='" . $division->id . "''>" . $leagueData->print_division_name($division->id) . "</option>\n";
        }
        print "</select>";
    } else {
        print "&nbsp;";
    }
    print "</td><td class='date last'><input name='start' type='date' required='required'/></td><td class='date last'><input name='end' type='date' required='required'/></td><td class='button last'><input type='submit' name='create' value='create'></td></tr>\n";
    print_form_table_end();

    // PLAYERS
    print_table_start('Players', 'action_table');
    print "<tr><th class='division'>Division</th><th class='name'>User</th><th class='button last'></th></tr>\n";
    foreach ($leagueData->player_list as $player) {
        print_form(
            array('division', 'name'), array($leagueData->print_division_name($player->division_id), $leagueData->print_user_name($player->id, false)),
            array('player_id'), array($player->id)
        );
    }
    print_create_form_start('player');
    print "<tr class='create_row'><td class='division last'>";
    if (count($leagueData->division_list) > 0) {
        print "<select name='division_id'>";
        foreach ($leagueData->division_list as $division) {
            print "<option value='" . $division->id . "''>" . $leagueData->print_division_name($division->id) . "</option>\n";
        }
        print "</select>";
    } else {
        print "&nbsp;";
    }
    print "</td><td class='name last'>";
    if (count($leagueData->user_list) > 0) {
        print "<select name='user_id'>";
        foreach ($leagueData->user_list as $user) {
            print "<option value='" . $user->id . "''>" . $user->name . "</option>\n";
        }
        print "</select>";
    } else {
        print "&nbsp;";
    }
    print "</td><td class='button last'><input type='submit' name='create' value='create'></td></tr>\n";
    print_form_table_end();


    // MATCHES
    print "<h2 class='table_title'>Matches</h2>";
    foreach ($leagueData->round_list as $round_table) {
        print_table_start($leagueData->print_division_name($round_table->division_id), 'action_table', 'table_subtitle');
        print "<tr><th class='round'>Round</th><th class='player'>Player One</th><th class='player'>Player Two</th><th class='button last'></th></tr>\n";
        foreach ($leagueData->match_list as $match) {
            if ($match->round_id == $round_table->id) {
                print_form(
                    array('round', 'player', 'player'), array($leagueData->print_round_name($match->round_id, false), $leagueData->print_user_name($match->player_one_id, false), $leagueData->print_user_name($match->player_two_id, false)),
                    array('match_id'), array($match->id)
                );
            }
        }
        print_create_form_start('match');
        print "<tr><td class='round last'>";
        if (count($leagueData->round_list) > 0) {
            print "<select name='round_id'>";
            foreach ($leagueData->round_list as $round) {
                if ($round->id == $round_table->id) {
                    print "<option value='" . $round->id . "''>" . $leagueData->print_round_name($round->id, false) . "</option>\n";
                }
            }
            print "</select>";
        } else {
            print "&nbsp;";
        }
        print "</td><td class='player last'>";
        if (count($leagueData->user_list) > 0) {
            print "<select name='player_one_id'>";
            foreach ($leagueData->player_list as $player) {
                if ($player->division_id == $round_table->division_id) {
                    print "<option value='" . $player->id . "''>" . $leagueData->print_user_name($player->id, false) . "</option>\n";
                }
            }
            print "</select>";
        } else {
            print "&nbsp;";
        }
        print "</td><td class='player last'>";
        if (count($leagueData->user_list) > 0) {
            print "<select name='player_two_id'>";
            foreach ($leagueData->player_list as $player) {
                if ($player->division_id == $round_table->division_id) {
                    print "<option value='" . $player->id . "''>" . $leagueData->print_user_name($player->id, false) . "</option>\n";
                }
            }
            print "</select>";
        } else {
            print "&nbsp;";
        }
        print "</td><td class='button last'><input type='submit' name='create' value='create'></td></tr>\n";
        print_form_table_end();
    }


//print choose_players($listViewData, 'player_two_id', 'print_user_name');

//function choose_players(LeagueData $leagueData, $field_id, $callback)
//{
//    if (count($leagueData->user_list) > 0) {
//        print "<select name='" . $field_id . "'>";
//        foreach ($leagueData->player_list as $player) {
//            print "<option value='" . $player->id . "''>" . call_user_func(array($leagueData, $callback), $player->user_id) . "</option>\n";
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