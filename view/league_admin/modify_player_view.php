<?php
require_once('../../load.php');

if (Session::is_administrator()) {

    load::load_file('view/league_admin', 'league_imports.php');
    load::load_file('view/league_admin', 'league_data.php');
    $id = Parameters::read_request_input('id');

    $player = PlayerDAO::get_by_id($id);
    $user = UserDAO::get_by_id($player->user_id);

    if (empty($player)) {
        $GLOBALS['errors']->add('no_match', 'No player found with id ' . $id . '.');
    }

    Page::header(Link::League_Admin_Modify_Player, array(), '', '', array(Link::get_link(Link::League_Admin_Modify_Player)));

    if (!$GLOBALS['errors']->has_errors()) {
        $leagueData = new LeagueData();

        print "<form method='post' action='" . Link::root . Link::League_Admin_Modify_Controller_Url . "'><div class='delete_sessions_form'>";
        print "<input name='type' type='hidden' value='player'>";
        print "<p><label class='id' for='id'>Player Id:</label><input id='id' name='id' type='text' value='$player->id' readonly='readonly'/></p>";
        print "<p><label class='name' for='name'>Name:</label><input id='name' name='name' type='text' value='$user->name' readonly='readonly'/></p>";
        print "<p><label class='email' for='email'>Email:</label><input id='email' name='email' type='text' value='$user->email' readonly='readonly'/></p>";
        print "<p><label class='status' for='status'>Status:</label>";
        print "<select name='status'>";
        print "<option " . ($player->status == Player::active ? Form::selected_string : '') . " value='" . Player::active . "''>" . Player::active . "</option>";
        print "<option " . ($player->status == Player::inactive ? Form::selected_string : '') . " value='" . Player::inactive . "''>" . Player::inactive . "</option>";
        print "</select>";
        print "</p>";
        print "<p class='submit'><input class='submit' type='submit' name='save' value='save'></p>";
        print "</div></form><br/>";
    }

    Page::footer();

} else {

    Page::not_authorised();

}

?>