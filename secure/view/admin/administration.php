<?php
require_once('../../load.php');

$user = Session::get_user();

if (!empty($user)) {

    Page::header(Link::Administration);
    print "<p>" . Link::get_link(Link::Leagues) . "</p>";
    print "<p>" . Link::get_link(Link::Users_Sessions) . "</p>";
    Page::footer();
    exit;

} else {

    Page::not_logged_in();

}

?>