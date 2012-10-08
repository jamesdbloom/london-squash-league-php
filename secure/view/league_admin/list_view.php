<?php
require_once('../../load.php');
load::load_file('view/admin', 'form_output.php');
load::load_file('view/league_admin', 'league_data.php');

//
// READ DATABASE DATA
//
$leagueData = new LeagueData();
Page::header('Administration', array('/secure/view/global.css', '/secure/view/admin/admin.css'));

//
// CLUBS
//
print_table_start('Clubs');
print "<tr><th class='id'>Id</th><th class='name'>Name</th><th class='address'>Address</th><th class='button'></th></tr>\n";
foreach ($leagueData->club_list as $club) {
    print_delete_form('club_id', array('id', 'name', 'address'), array($club->id, $club->name, $club->address));
}
print_create_form_start('club');
print "<tr><td class='id'>&nbsp;</td><td class='name'><input name='name' type='text' pattern='.{3,25}' required='required'></td><td class='address'><input name='address' type='text' pattern='.{10,125}'></td><td class='button'><input type='submit' name='create' value='create'></td></tr>\n";
print_form_table_end();

//
// LEAGUES
//
print_table_start('Leagues');
print "<tr><th class='id'>Id</th><th class='name'>Club</th><th class='name'>League</th><th class='button'></th></tr>\n";
foreach ($leagueData->league_list as $league) {
    print_delete_form('league_id', array('id', 'name', 'name'), array($league->id, $leagueData->print_club_name($league->club_id), $league->name));
}
print_create_form_start('league');
print "<tr><td class='id'>&nbsp;</td><td class='name'>";
if (count($leagueData->club_list) > 0) {
    print "<select name='club_id'>";
    foreach ($leagueData->club_list as $club) {
        print "<option value='" . $club->id . "''>$club->name</option>\n";
    }
    print "</select>";
} else {
    print "&nbsp;";
}
print "</td><td class='name'><input name='name' type='text' pattern='.{3,25}' required='required'></td><td class='button'><input type='submit' name='create' value='create'></td></tr>\n";
print_form_table_end();

//
// DIVISIONS
//
print_table_start('Divisions');
print "<tr><th class='id'>Id</th><th class='name'>League</th><th class='name'>Division</th><th class='button'></th></tr>\n";
foreach ($leagueData->division_list as $division) {
    print_delete_form('division_id', array('id', 'name', 'name'), array($division->id, $leagueData->print_league_name($division->league_id), $division->name));
}
print_create_form_start('division');
print "<tr><td class='id'>&nbsp;</td><td class='name'>";
if (count($leagueData->league_list) > 0) {
    print "<select name='league_id'>";
    foreach ($leagueData->league_list as $league) {
        print "<option value='" . $league->id . "''>" . $leagueData->print_league_name($league->id) . "</option>\n";
    }
    print "</select>";
} else {
    print "&nbsp;";
}
print "</td><td class='name'><input name='name' type='text' pattern='.{3,25}' required='required'></td><td class='button'><input type='submit' name='create' value='create'></td></tr>\n";
print_form_table_end();

//
// ROUNDS
//
print_table_start('Rounds');
print "<tr><th class='id'>Id</th><th class='name'>Division</th><th class='date'>Start</th><th class='date'>End</th><th class='button'></th></tr>\n";
foreach ($leagueData->round_list as $round) {
    print_delete_form('round_id', array('id', 'name', 'date', 'date'), array($round->id, $leagueData->print_division_name($round->division_id), date('d-M-Y', $round->start), date('d-M-Y', $round->end)));
}
print_create_form_start('round');
print "<tr><td class='id'>&nbsp;</td><td class='name'>";
if (count($leagueData->division_list) > 0) {
    print "<select name='division_id'>";
    foreach ($leagueData->division_list as $division) {
        print "<option value='" . $division->id . "''>" . $leagueData->print_division_name($division->id) . "</option>\n";
    }
    print "</select>";
} else {
    print "&nbsp;";
}
print "</td><td class='date'><input name='start' type='date' required='required'/></td><td class='date'><input name='end' type='date' required='required'/></td><td class='button'><input type='submit' name='create' value='create'></td></tr>\n";
print_form_table_end();

//
// MATCHES
//
print_table_start('Matches');
print "<tr><th class='id'>Id</th><th class='name'>Round</th><th class='name'>Player One</th><th class='name'>Player Two</th><th class='button'></th></tr>\n";
foreach ($leagueData->match_list as $match) {
    print_delete_form('match_id', array('id', 'name', 'name', 'name'), array($match->id, $leagueData->print_round_name($match->round_id), $leagueData->print_user_name($match->player_one_id), $leagueData->print_user_name($match->player_two_id)));
}
print_create_form_start('match');
print "<tr><td class='id'>&nbsp;</td><td class='name'>";
if (count($leagueData->round_list) > 0) {
    print "<select name='round_id'>";
    foreach ($leagueData->round_list as $round) {
        print "<option value='" . $round->id . "''>" . $leagueData->print_round_name($round->id) . "</option>\n";
    }
    print "</select>";
} else {
    print "&nbsp;";
}
print "</td><td class='name'>";
if (count($leagueData->user_list) > 0) {
    print "<select name='player_one_id'>";
    foreach ($leagueData->player_list as $player) {
        print "<option value='" . $player->id . "''>" . $leagueData->print_user_name($player->id) . "</option>\n";
    }
    print "</select>";
} else {
    print "&nbsp;";
}
print "</td><td class='name'>";
//print choose_players($listViewData, 'player_two_id', 'print_user_name');
if (count($leagueData->user_list) > 0) {
    print "<select name='player_two_id'>";
    foreach ($leagueData->player_list as $player) {
        print "<option value='" . $player->id . "''>" . $leagueData->print_user_name($player->id) . "</option>\n";
    }
    print "</select>";
} else {
    print "&nbsp;";
}
print "</td><td class='button'><input type='submit' name='create' value='create'></td></tr>\n";
print_form_table_end();

//
// PLAYERS
//
print_table_start('Players');
print "<tr><th class='id'>Id</th><th class='name'>Division</th><th class='name'>User</th><th class='button'></th></tr>\n";
foreach ($leagueData->player_list as $player) {
    print_delete_form('player_id', array('id', 'name', 'name'), array($player->id, $leagueData->print_division_name($player->division_id), $leagueData->print_user_name($player->id, false)));
}
print_create_form_start('player');
print "<tr><td class='id'>&nbsp;</td><td class='name'>";
if (count($leagueData->division_list) > 0) {
    print "<select name='division_id'>";
    foreach ($leagueData->division_list as $division) {
        print "<option value='" . $division->id . "''>" . $leagueData->print_division_name($division->id) . "</option>\n";
    }
    print "</select>";
} else {
    print "&nbsp;";
}
print "</td><td class='name'>";
if (count($leagueData->user_list) > 0) {
    print "<select name='user_id'>";
    foreach ($leagueData->user_list as $user) {
        print "<option value='" . $user->id . "''>" . $user->name . "</option>\n";
    }
    print "</select>";
} else {
    print "&nbsp;";
}
print "</td><td class='button'><input type='submit' name='create' value='create'></td></tr>\n";
print_form_table_end();

print "<p><a href='recreate_tables.php'>Recreate Table</a></p>";
print "<p><a href='/secure'>Home</a></p>";


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

?>