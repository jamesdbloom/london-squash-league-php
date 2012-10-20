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

    $player = $leagueData->player_by_user_id_map[$user->id];

    if (!empty($match) && !empty($player) && ($match->player_one_id == $player->id || $match->player_two_id == $player->id)) {

        Page::header(Link::Enter_Score);

        if (!$GLOBALS['errors']->has_errors()) {
            print "<h2 class='form_subtitle'>" . $leagueData->print_match_name($match_id) . "</h2>";
            print "<p class='message'>Please enter the score for your match</p>";
            print "<form method='post' action='score_controller.php'><div class='delete_sessions_form'>";
            print "<input type='hidden' name='match_id' value='$match_id'/>";
            print "<p><label class='last_activity_date' for='score'>Score:</label><input id='score' name='score' type='text' autocorrect='off' autocapitalize='off' autocomplete='off' required='required' pattern='\\d-\\d'/></p>";
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
