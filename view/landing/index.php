<?php
require_once('../../load.php');

Page::header('Home');
$user = Session::get_user(false);

if (!empty($user)) {
    print "<ol class='link_list'>";
    if ($user->is_administrator()) {
        print "<li>" . Link::get_link(Link::Administration) . "</li>";
    }
    if ($user->is_league_manager()) {
        print "<li>" . Link::get_link(Link::Print_League) . "</li>";
    }
    print "<li>" . Link::get_link(Link::League, false, "View Your League") . "</li>";
    print "<li>" . Link::get_link(Link::Ranking, false, "Player Ranking") . "</li>";
    print "<li>" . Link::get_link(Link::Enter_Score, false, "Enter Match Score") . "</li>";
    print "<li>" . Link::get_link(Link::Account, false, "Account Settings") . "</li>";
    print "<li>" . Link::get_link(Link::Join_A_League, false, "Join A New League") . "</li>";
    print "<li>" . Link::get_link(Link::Contact_Us) . "</li>";
    print "<li>" . Link::get_link(Link::Report_Issue) . "</li>";
    print "<li>" . Link::get_link(Link::Logout) . "</li>";
    print "</ol>";
} else {
    print "<ol class='link_list'>";
    print "<li>" . Link::get_link(Link::Register, false, "1. " . Link::Register) . "</li>";
    print "<li>" . Link::get_link(Link::Join_A_League, false, "2. " . Link::Join_A_League) . "</li>";
    print "<li>" . Link::get_link(Link::Login) . "</li>";
    print "</ol>";
    load::include_file('view/login', 'login_form.php');
}
Page::footer();
?>