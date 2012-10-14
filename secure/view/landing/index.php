<?php
require_once('../../load.php');

Page::header('London Squash League');
if (Session::has_active_session()) {
    print "<ol class='landing loggedin'>";
    print "<li>" . Link::get_link(Link::View_League) . "</li>";
    print "<li>" . Link::get_link(Link::Enter_Score) . "</li>";
    print "<li>" . Link::get_link(Link::Account_Settings) . "</li>";
    print "</ol>";
} else {
    print "<ol class='landing login'>";
    print "<li>1. " . Link::get_link(Link::Register) . "</li>";
    print "<li>2. " . Link::get_link(Link::Join_A_League) . "</li>";
    print "</ol>";
    load::include_file('view/login', 'login_form.php');
}
Page::footer();
?>