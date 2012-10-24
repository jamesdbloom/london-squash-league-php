<?php
require_once('../../load.php');
load::load_file('view/admin', 'form_output.php');
load::load_file('view/user_admin', 'user_data.php');

if (Session::is_administrator()) {

    $userData = new UserData();
    Page::header(Link::Users_Sessions, array(), '', '', array(Link::get_link(Link::Recreate_Tables)));

    // USERS
    print_table_start('Users', 'action_table');
    print "<tr><th class='name'>Name</th><th class='email hide_on_very_small_screen'>Email</th><th class='mobile row_end_before_hidden_medium_screen'>Mobile</th><th class='mobile_privacy hide_on_medium_screen'>Mobile Privacy</th><th class='button last'></th></tr>";
    foreach ($userData->user_list as $user) {
        print_form(
            array('name', 'email hide_on_very_small_screen', 'mobile row_end_before_hidden_medium_screen', 'mobile_privacy hide_on_medium_screen'), array($user->name, $user->email, "<a href='tel:$user->mobile'>$user->mobile<a/>", User::get_mobile_privacy_text($user->mobile_privacy)),
            array('user_id'), array($user->id)
        );
    }
    print_create_form_start('user');
    print "<tr class='create_row'>";
    print "<td class='name last'><input name='name' type='text' pattern='.{3,25}' required='required'></td>";
    print "<td class='email last hide_on_very_small_screen'><input name='email' type='email' pattern=\"[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\" required='required'></td>";
    print "<td class='mobile row_end_before_hidden_medium_screen last'><input name='mobile' type='tel' pattern='\d{5,25}'></td>";
    print "<td class='mobile_privacy last hide_on_medium_screen'><select name='mobile_privacy'>";
    print "<option value=''>Please select...</option>";
    print "<option value='" . User::secret . "'>" . User::get_mobile_privacy_text(User::secret) . "</option>";
    print "<option value='" . User::division . "'>" . User::get_mobile_privacy_text(User::division) . "</option>";
    print "<option value='" . User::league . "'>" . User::get_mobile_privacy_text(User::league) . "</option>";
    print "<option value='" . User::everyone . "'>" . User::get_mobile_privacy_text(User::everyone) . "</option>";
    print "</select></td>";
    print "<td class='button last'><input type='submit' name='create' value='create'></td></tr>";
    print_form_table_end();

    // SESSIONS
    print_table_start('Sessions', 'action_table');
    print "<tr><th class='session'>Id</th><th class='name'>User</th><th class='status hide_on_small_screen'>Status</th><th class='date hide_on_very_small_screen'>Created</th><th class='date'>Last Activity</th><th class='button last'></th></tr>";
    foreach ($userData->session_list as $session) {
        print_form(
            array('session', 'name', 'status hide_on_small_screen', 'date hide_on_very_small_screen', 'date'), array(implode(' ', str_split($session->id, strlen($session->id) / 5)), $userData->print_user_name($session->user_id), $session->status, date('Y-m-d H:i:s', $session->created_date), date('Y-m-d H:i:s', $session->last_activity_date)),
            array('session_id'), array($session->id)
        );
    }
    print_create_form_start('session');
    print "<tr class='create_row'><td colspan='2' class='name last'>";
    if (count($userData->user_list) > 0) {
        print "<select name='user_id'>";
        foreach ($userData->user_list as $user) {
            print "<option value='" . $user->id . "''>$user->name</option>\n";
        }
        print "</select>";
    }
    print "</td><td class='status last hide_on_small_screen'>&nbsp;</td><td class='date last hide_on_very_small_screen'>&nbsp;</td><td class='date last'>&nbsp;</td><td class='button last'><input type='submit' name='create' value='create'></td></tr>";
    print_form_table_end();

    print "<h2 class='form_title'>Delete Old Sessions</h2>";
    print "<form method='post' action='delete_controller.php'><div class='delete_sessions_form'>";
    print "<p><label class='last_activity_date' for='session_last_activity_field'>Last Activity Date:</label><input id='session_last_activity_field' name='session_last_activity' type='date' /></p>";
    print "<p><label class='created_date' for='session_created_field'>Created Date:</label><input id='session_created_field' name='session_created' type='date' /></p>";
    print "<p class='submit'><input class='submit' type='submit' name='delete' value='delete'></p>";
    print "</div></form><br/>";

    Page::footer();

} else {

    Page::not_authorised();

}

?>