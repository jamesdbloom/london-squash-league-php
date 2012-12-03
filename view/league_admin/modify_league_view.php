<?php
require_once('../../load.php');

if (Session::is_administrator()) {

    load::load_file('view/league_admin', 'league_imports.php');
    load::load_file('view/league_admin', 'league_data.php');
    $id = Parameters::read_request_input('id');

    $league = LeagueDAO::get_by_id($id);

    if (empty($league)) {
        $GLOBALS['errors']->add('no_match', 'No league found with id ' . $id . '.');
    }

    Page::header(Link::League_Admin_Modify_League, array(), '', '', array(Link::get_link(Link::League_Admin_Modify_League)));

    if (!$GLOBALS['errors']->has_errors()) {
        $leagueData = new LeagueData();

        print "<form method='post' action='" . Link::root . Link::League_Admin_Modify_Controller_Url . "'><div class='delete_sessions_form'>";
        print "<input name='type' type='hidden' value='league'>";
        print "<p><label class='id' for='id'>League Id:</label><input id='id' name='id' type='text' value='$league->id' readonly='readonly'/></p>";
        print "<p><label class='name' for='name'>Name:</label><input class='show_validation' id='name' name='name' type='text' value='$league->name' autocorrect='off' autocapitalize='off' autocomplete='off' pattern='.{3,25}' required='required'/></p>";
        print "<p><label class='club_id' for='club_id'>Club:</label>";
        if (count($leagueData->club_list) > 0) {
            print "<select name='club_id'>";
            foreach ($leagueData->club_list as $club) {
                print "<option " . ($club->id == $league->club_id ? Form::selected_string : '') . " value='" . $club->id . "''>$club->name</option>";
            }
            print "</select>";
        } else {
            print "&nbsp;";
        }
        print "</p>";
        print "<p class='submit'><input class='submit' type='submit' name='save' value='save'></p>";
        print "</div></form><br/>";
    }

    Page::footer();

} else {

    Page::not_authorised();

}

?>