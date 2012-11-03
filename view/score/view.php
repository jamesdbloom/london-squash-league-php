<?php
require_once('../../load.php');

$user = Session::get_user(true);

if (!empty($user)) {

    $match_id = Parameters::read_request_input('match_id');
    if (!empty($match_id)) {


        load::load_file('view/league_admin', 'league_data.php');

        $leagueData = new LeagueData();

        $match = $leagueData->match_map[$match_id];

        if (empty($match)) {
            $GLOBALS['errors']->add('no_match', 'No match found with id ' . $match_id . '.');
        }

        if ($leagueData->user_is_player_in_match($user->id, $match_id)) {

            Page::header(Link::Enter_Score);

            if (!$GLOBALS['errors']->has_errors()) {
                print "<h2 class='form_subtitle'><p class='enter_score_subtitle'>" . $leagueData->print_match_name($match_id, true, LeagueData::name_spacer . "</p><p class='enter_score_subtitle'>") . "</p></h2>";
                print "<p class='message'>Please enter the score for your match <strong>" . $leagueData->print_match_name($match_id, false) . "</strong><br/><br/>Note: please use format x-x</p>";
                print "<form method='post' action='" . Link::root . Link::Enter_Score_Controller_Url . "'><div class='delete_sessions_form'>";
                print "<input type='hidden' name='" . Urls::redirect_to . "' value='" . Parameters::read_header('HTTP_REFERER', Link::root . Link::League_Url) . "'/>";
                print "<input type='hidden' name='match_id' value='$match_id'/>";
                print "<p><label class='last_activity_date' for='score'>Score:</label><input class='show_validation' id='score' name='score' type='text' autocorrect='off' autocapitalize='off' autocomplete='off' required='required' pattern='[0-9]{1,2}-[0-9]{1,2}'/></p>";
                print "<p class='submit'><input class='submit' type='submit' name='save' value='save'></p>";
                print "</div></form><br/>";
            }

            Page::footer();

        } else {

            Headers::set_redirect_header(Link::root . Link::League_Url . '?message=only_match_players');

        }

    } else {
        Headers::set_redirect_header(Link::root . Link::League_Url . '?message=no_match_selected');
    }

}
?>
