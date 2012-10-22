<?php
require_once('../../load.php');

$user = Session::get_user();

if (!empty($user)) {

    Page::header(Link::Administration);
    print "<ol class='link_list'>";
    print "<li>" . Link::get_link(Link::League_Admin) . "</li>";
    print "<li>" . Link::get_link(Link::Users_Sessions) . "</li>";
    print "</ol>";
    Page::footer();
    exit;

} else {

    Page::not_logged_in();

}

?>