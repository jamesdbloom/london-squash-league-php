<?php
require_once('../../load.php');
load::load_file('view/admin', 'form_output.php');
load::load_file('view/user_admin', 'user_data.php');

if (Session::is_administrator()) {

    $userData = new UserData();
    Page::header(Link::Users_Sessions, array(), '', '', array(new Link('recreate_schema_controller.php', 'Recreate Table')));

    // USERS
    print_table_start('Users', 'action_table');
    print "<tr><th class='name'>Name</th><th class='email'>Email</th><th class='mobile'>Mobile</th><th class='button last'></th></tr>\n";
    foreach ($userData->user_list as $user) {
        print_form(
            array('name', 'email', 'mobile'), array($user->name, $user->email, "<a href='tel:$user->mobile'>$user->mobile<a/>"),
            array('user_id'), array($user->id)
        );
    }
    print_create_form_start('user');
    print "<tr class='create_row'><td class='name last'><input name='name' type='text' pattern='.{3,25}' required='required'></td><td class='email last'><input name='email' type='email' pattern=\"[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\" required='required'></td><td class='mobile last'><input name='mobile' type='tel' pattern='\d{5,25}'></td><td class='button last'><input type='submit' name='create' value='create'></td></tr>\n";
    print_form_table_end();

    // SESSIONS
    print_table_start('Sessions', 'action_table');
    print "<tr><th class='session'>Id</th><th class='name'>User</th><th class='status'>Status</th><th class='date'>Created</th><th class='date'>Last Activity</th><th class='button last'></th></tr>\n";
    foreach ($userData->session_list as $session) {
        print_form(
            array('session', 'name', 'status', 'date', 'date'), array(implode(' ', str_split($session->id, strlen($session->id) / 5)), $userData->print_user_name($session->user_id), $session->status, $session->created_date, $session->last_activity_date),
            array('session_id'), array($session->id)
        );
    }
    print_create_form_start('session');
    print "<tr class='create_row'><td class='session last'>&nbsp;</td><td class='name last'>";
    if (count($userData->user_list) > 0) {
        print "<select name='user_id'>";
        foreach ($userData->user_list as $user) {
            print "<option value='" . $user->id . "''>$user->name</option>\n";
        }
        print "</select>";
    }
    print "</td><td class='status last'>&nbsp;</td><td class='date last'>&nbsp;</td><td class='date last'>&nbsp;</td><td class='button last'><input type='submit' name='create' value='create'></td></tr>\n";
    print_form_table_end();

    print "<h2 class='form_title'>Delete Old Sessions</h2>";
    print "<form method='post' action='delete_controller.php'><div class='delete_sessions_form'>";
    print "<p><label class='last_activity_date' for='session_last_activity_field'>Last Activity Date:</label><input id='session_last_activity_field' name='session_last_activity' type='date' /></p>";
    print "<p><label class='created_date' for='session_created_field'>Created Date:</label><input id='session_created_field' name='session_created' type='date' /></p>";
    print "<p class='submit'><input class='submit' type='submit' name='delete' value='delete'></p>";
    print "</div></form><br/>";

    Page::footer(array(new Link('recreate_schema_controller.php', 'Recreate Table')));

} else {

    Page::not_authorised();

}

?>