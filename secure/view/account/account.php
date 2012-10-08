<?php
require_once('../../load.php');
load::load_file('view/admin', 'form_output.php');
load::load_file('view/account', 'account_data.php');

$user = Session::get_user();

//
// READ DATABASE DATA
//
$accountData = new AccountData();
Page::header('Account Settings - ' . $accountData->user->name, array('/secure/view/global.css', '/secure/view/admin/admin.css'));

//
// USERS
//
print_table_start('Account');
print "<tr><th class='id'>Id</th><th class='name'>Name</th><th class='email'>Email</th><th class='mobile'>Mobile</th><th class='button'></th></tr>\n";
foreach ($accountData->user_list as $user) {
    print_delete_form('user_id', array('id', 'name', 'email', 'mobile'), array($user->id, $user->name, $user->email, $user->mobile));
}
print_form_table_end();

//
// CLUBS
//
print_table_start('Clubs');
print "<tr><th class='id'>Id</th><th class='name'>Name</th><th class='address'>Address</th><th class='button'></th></tr>\n";
foreach ($accountData->club_list as $club) {
    print_delete_form('club_id', array('id', 'name', 'address'), array($club->id, $club->name, $club->address));
}
print_form_table_end();

//
// LEAGUES
//
print_table_start('Leagues');
print "<tr><th class='id'>Id</th><th class='name'>Club</th><th class='name'>League</th><th class='button'></th></tr>\n";
foreach ($accountData->league_list as $league) {
    print_delete_form('league_id', array('id', 'name', 'name'), array($league->id, $accountData->print_club_name($league->club_id), $league->name));
}
print_form_table_end();

//
// DIVISIONS
//
print_table_start('Divisions');
print "<tr><th class='id'>Id</th><th class='name'>League</th><th class='name'>Division</th><th class='button'></th></tr>\n";
foreach ($accountData->division_list as $division) {
    print_delete_form('division_id', array('id', 'name', 'name'), array($division->id, $accountData->print_league_name($division->league_id), $division->name));
}
print_form_table_end();

//
// ROUNDS
//
print_table_start('Rounds');
print "<tr><th class='id'>Id</th><th class='name'>Division</th><th class='date'>Start</th><th class='date'>End</th><th class='button'></th></tr>\n";
foreach ($accountData->round_list as $round) {
    print_delete_form('round_id', array('id', 'name', 'date', 'date'), array($round->id, $accountData->print_division_name($round->division_id), date('d-M-Y', $round->start), date('d-M-Y', $round->end)));
}
print_form_table_end();

//
// MATCHES
//
print_table_start('Matches');
print "<tr><th class='id'>Id</th><th class='name'>Round</th><th class='name'>Player One</th><th class='name'>Player Two</th><th class='button'></th></tr>\n";
foreach ($accountData->match_list as $match) {
    print_delete_form('match_id', array('id', 'name', 'name', 'name'), array($match->id, $accountData->print_round_name($match->round_id), $accountData->print_user_name($match->player_one_id), $accountData->print_user_name($match->player_two_id)));
}
print_form_table_end();

print "<p><a href='/secure'>Home</a></p>";

Page::footer();

?>