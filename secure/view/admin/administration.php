<?php
require_once('../../load.php');

$user = Session::get_user();

if (!empty($user)) {

    Page::header(Link::Administration);
    print "<ol class='landing loggedin'>";
    print "<li>" . Link::get_link(Link::Leagues) . "</li>";
    print "<li>" . Link::get_link(Link::Users_Sessions) . "</li>";
    print "</ol>";
    Page::footer();
    exit;

} else {

    Page::not_logged_in();

}

?>