<?php
require_once('../../load.php');

if (Session::is_administrator()) {

    load::load_file('view/league_admin', 'league_imports.php');
    load::load_file('view/league_admin', 'league_data.php');
    $id = Parameters::read_request_input('id');

    $round = RoundDAO::get_by_id($id);

    if (empty($round)) {
        $GLOBALS['errors']->add('no_match', 'No league found with id ' . $id . '.');
    }

    Page::header(Link::League_Admin_Modify_Round, array(), '', '', array(Link::get_link(Link::League_Admin_Modify_Round)));

    if (!$GLOBALS['errors']->has_errors()) {
        $leagueData = new LeagueData();

        print "<form method='post' action='" . Link::root . Link::League_Admin_Modify_Controller_Url . "'><div class='delete_sessions_form'>";
        print "<input name='type' type='hidden' value='round'>";
        print "<p><label class='id' for='id'>Round Id:</label><input id='id' name='id' type='text' value='$round->id' readonly='readonly'/></p>";
        print "<p><label class='start' for='start'>Start:</label><input id='start' name='start' type='text' value='" . date('d-M-Y', $round->start) . "' autocorrect='off' autocapitalize='off' autocomplete='off' pattern='.{3,25}' required='required'/></p>";
        print "<p><label class='end' for='end'>End:</label><input id='end' name='end' type='text' value='" . date('d-M-Y', $round->end) . "' autocorrect='off' autocapitalize='off' autocomplete='off' pattern='.{3,25}' required='required'/></p>";
        print "<p><label class='league_id' for='league_id'>League:</label>";
        if (count($leagueData->division_list) > 0) {
            print "<select name='league_id'>";
            foreach ($leagueData->league_list as $league) {
                print "<option " . ($league->id == $round->league_id ? Form::selected_string : '') . " value='" . $league->id . "''>" . $leagueData->print_league_name($league->id) . "</option>";
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