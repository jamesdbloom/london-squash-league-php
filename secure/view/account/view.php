<?php
require_once('../../load.php');

$user = Session::get_user();

if (!empty($user)) {

    load::load_file('view/admin', 'form_output.php');
    load::load_file('view/account', 'account_data.php');

    $accountData = new AccountData();
    Page::header(Link::Account_Settings, array(), $accountData->user->name);

    // USERS
    print_table_start('User');
    print "<tr><th class='name'>Name</th><th class='email'>Email</th><th class='mobile'>Mobile</th></tr>";
    print_table_row(array('name', 'email', 'mobile'), array($user->name, $user->email, "<a href='tel:$user->mobile'>$user->mobile<a/>"));
    print_form_table_end();

    print "<ol class='link_list'>";
    print "<li>" . Link::get_link(Link::Update_Password) . "</li>";
    print "</ol>";

    // DIVISIONS
    $unregistered_divisions = $accountData->divisions_in_unregistered_leagues();
    print_table_start('Divisions', 'action_table');
    print "<tr><th class='club'>Club</th><th class='league_unqualified'>League</th><th class='division_unqualified'>Division</th><th class='status'>Status</th><th class='button last'></th></tr>";
    foreach ($accountData->user_division_list as $division) {
        $league = $accountData->league_map[$division->league_id];
        $player = $accountData->user_division_to_player_map[$division->id];
        print_form(
            array('club', 'league_unqualified', 'division_unqualified', 'status'), array($accountData->print_club_name($league->club_id), $league->name, $division->name, $player->status),
            array('division_id', 'user_id'), array($division->id, $user->id),
            'unregister'
        );
    }
    print_create_form_start('player');
    print "<input name='user_id' type='hidden' value='" . $user->id . "'>";
    if (count($unregistered_divisions) > 0) {
        print "<tr class='create_row'><td colspan='4' class='name last'>";
        print "<select name='division_id'>";
        foreach ($unregistered_divisions as $division) {
            print "<option value='" . $division->id . "''>" . $accountData->print_division_name($division->id) . "</option>";
        }
        print "</select>";
        print "</td><td class='button last'><input type='submit' name='register' value='register'></td></tr>";
    }
    print_form_table_end();

    // ROUNDS
    print_table_start('Rounds');
    print "<tr><th class='division'>Division</th><th class='date'>Start</th><th class='date'>End</th></tr>";
    foreach ($accountData->user_round_list as $round) {
        print_table_row(array('division', 'date', 'date'), array($accountData->print_division_name($round->division_id), date('d-M-Y', $round->start), date('d-M-Y', $round->end)));
    }
    print_form_table_end();

    // MATCHES
    print_table_start('Matches');
    print "<tr><th class='division'>Division</th><th class='round_nowrap'>Round</th><th class='player'>Player One</th><th class='player'>Player Two</th></tr>";
    foreach ($accountData->user_match_list as $match) {
        $round = $accountData->round_map[$match->round_id];
        print_table_row(array('division', 'round_nowrap', 'player', 'player'), array($accountData->print_division_name($round->division_id), $round->name, $accountData->print_user_name($match->player_one_id, false), $accountData->print_user_name($match->player_two_id, false)));
    }
    print_form_table_end();

//    // CLUBS
//    print_table_start('Available Clubs');
//    print "<tr><th class='name'>Name</th><th class='address last'>Address</th></tr>";
//    foreach ($accountData->club_list as $club) {
//        print_table_row(array('name', 'address last'), array($club->id, $club->name, $club->address));
//    }
//    print_form_table_end();
//
//    // LEAGUES
//    print_table_start('Available Leagues');
//    print "<tr><th class='name last'>Division</th></tr>";
//    foreach ($accountData->user_league_list as $league) {
//        print_table_row(array('name last'), array($league->id, $accountData->print_league_name($league->id)));
//    }
//    print_form_table_end();

    Page::footer();

} else {

    Page::not_logged_in();

}

?>