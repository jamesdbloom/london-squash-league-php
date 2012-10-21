<?php
require_once('../../load.php');

$user = Session::get_user();

if (!empty($user)) {

    load::load_file('view/league_admin', 'league_data.php');

    $match_id = Parameters::read_request_input('match_id');
    $leagueData = new LeagueData();

    if (empty($match_id)) {
        $GLOBALS['errors']->add('no_match', '<strong>ERROR</strong>: No match is specified .');
    } else {
        $match = $leagueData->match_map[$match_id];
    }

    if (empty($match)) {
        $GLOBALS['errors']->add('no_match', '<strong>ERROR</strong>: No match found with id ' . $match_id . '.');
    }

    if ($leagueData->user_is_player_in_match($user->id, $match_id)) {

        Page::header(Link::Enter_Score);

        if (!$GLOBALS['errors']->has_errors()) {
            print "<h2 class='form_subtitle'><p>" . $leagueData->print_match_name($match_id, true, '</p><p>') . "</p></h2>";
            print "<p class='message'>Please enter the score for your match " . $leagueData->print_match_name($match_id, false) . "<br/><br/>Note: Please use format x-x</p>";
            print "<form method='post' action='score_controller.php'><div class='delete_sessions_form'>";
            print "<input type='hidden' name='match_id' value='$match_id'/>";
            print "<p><label class='last_activity_date' for='score'>Score:</label><input class='show_validation' id='score' name='score' type='text' autocorrect='off' autocapitalize='off' autocomplete='off' required='required' pattern='[0-9]{1,2}-[0-9]{1,2}'/></p>";
            print "<p class='submit'><input class='submit' type='submit' name='save' value='save'></p>";
            print "</div></form><br/>";
        }

        Page::footer();

    } else {

        Headers::set_redirect_header(Link::View_League_Url . '?message=only_match_players');

    }

} else {

    Page::not_logged_in();

}
?>
