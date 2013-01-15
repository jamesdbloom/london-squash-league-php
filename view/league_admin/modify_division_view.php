<?php
require_once('../../load.php');

if (Session::is_administrator()) {

    load::load_file('view/league_admin', 'league_imports.php');
    load::load_file('view/league_admin', 'league_data.php');
    $id = Parameters::read_request_input('id');

    $division = DivisionDAO::get_by_id($id);

    if (empty($division)) {
        $GLOBALS['errors']->add('no_match', 'No division found with id ' . $id . '.');
    }

    Page::header(Link::League_Admin_Modify_Division, array(), '', '', array(Link::get_link(Link::League_Admin_Modify_Division)));

    if (!$GLOBALS['errors']->has_errors()) {
        $leagueData = new LeagueData();

        print "<form method='post' action='" . Link::root . Link::League_Admin_Modify_Controller_Url . "'><div class='delete_sessions_form'>";
        print "<input name='type' type='hidden' value='division'>";
        print "<p><label class='id' for='id'>Division Id:</label><input id='id' name='id' type='text' value='$division->id' readonly='readonly'/></p>";
        print "<p><label class='name' for='name'>Name:</label><input class='show_validation' id='name' name='name' type='text' value='$division->name' autocorrect='off' autocapitalize='off' autocomplete='off' pattern='.{3,25}' required='required'/></p>";
        print "<p><label class='league_id' for='league_id'>League:</label>";
        if (count($leagueData->league_list) > 0) {
            print "<select name='league_id'>";
            foreach ($leagueData->league_list as $round) {
                print "<option " . ($round->id == $division->league_id ? Form::selected_string : '') . " value='" . $round->id . "''>$round->name</option>";
            }
            print "</select>";
        } else {
            print "&nbsp;";
        }
        print "</p>";
        print "<p><label class='round_id' for='round_id'>Round:</label>";
        if (count($leagueData->round_list) > 0) {
            print "<select name='round_id'>";
            foreach ($leagueData->round_list as $round) {
                print "<option " . ($round->id == $division->round_id ? Form::selected_string : '') . " value='" . $round->id . "''>$round->name</option>";
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