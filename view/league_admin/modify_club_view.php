<?php
require_once('../../load.php');

if (Session::is_administrator()) {

    load::load_file('view/league_admin', 'league_imports.php');
    $id = Parameters::read_request_input('id');

    $club = ClubDAO::get_by_id($id);

    if (empty($club)) {
        $GLOBALS['errors']->add('no_match', 'No club found with id ' . $id . '.');
    }

    Page::header(Link::League_Admin_Modify_Club, array(), '', '', array(Link::get_link(Link::League_Admin_Modify_Club)));

    if (!$GLOBALS['errors']->has_errors()) {
        print "<form method='post' action='" . Link::root . Link::League_Admin_Modify_Controller_Url . "'><div class='delete_sessions_form'>";
        print "<input name='type' type='hidden' value='club'>";
        print "<p><label class='id' for='id'>Club Id:</label><input id='id' name='id' type='text' value='$club->id' readonly='readonly'/></p>";
        print "<p><label class='name' for='name'>Name:</label><input class='show_validation' id='name' name='name' type='text' value='$club->name' autocorrect='off' autocapitalize='off' autocomplete='off' pattern='.{3,25}' required='required'/></p>";
        print "<p><label class='address' for='address'>Address:</label><input class='show_validation' id='address' name='address' type='text' value='$club->address' autocorrect='off' autocapitalize='off' autocomplete='off' pattern='.{10,125}'/></p>";
        print "<p class='submit'><input class='submit' type='submit' name='save' value='save'></p>";
        print "</div></form><br/>";
    }

    Page::footer();

} else {

    Page::not_authorised();

}

?>