<?php
require_once('../../load.php');
load::load_file('view/admin', 'form_output.php');
load::load_file('view/user_admin', 'user_data.php');

//
// READ DATABASE DATA
//
$userData = new UserData();
Page::header('Administration', array('/secure/view/global.css', '/secure/view/admin/admin.css'));

//
// USERS
//
print_table_start('Users');
print "<tr><th class='id'>Id</th><th class='name'>Name</th><th class='email'>Email</th><th class='mobile'>Mobile</th><th class='button last'></th></tr>\n";
foreach ($userData->user_list as $user) {
    print_delete_form('user_id', array('id', 'name', 'email', 'mobile'), array($user->id, $user->name, $user->email, $user->mobile));
}
print_create_form_start('user');
print "<tr><td class='id'>&nbsp;</td><td class='name'><input name='name' type='text' pattern='.{3,25}' required='required'></td><td class='email'><input name='email' type='email' pattern=\"[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\" required='required'></td><td class='mobile'><input name='mobile' type='tel' pattern='\d{5,25}'></td><td class='button last'><input type='submit' name='create' value='create'></td></tr>\n";
print_form_table_end();

//
// SESSIONS
//
print_table_start('Sessions');
print "<tr><th class='session'>Id</th><th class='name'>User</th><th class='status'>Status</th><th class='date'>Created</th><th class='date'>Last Activity</th><th class='button last'></th></tr>\n";
foreach ($userData->session_list as $session) {
    print_delete_form('session_id', array('session', 'name', 'status', 'date', 'date'), array($session->id, $userData->print_user_name($session->user_id), $session->status, $session->created_date, $session->last_activity_date));
}
print_create_form_start('session');
print "<tr><td class='session'>&nbsp;</td><td class='name'>";
if (count($userData->user_list) > 0) {
    print "<select name='user_id'>";
    foreach ($userData->user_list as $user) {
        print "<option value='" . $user->id . "''>$user->name</option>\n";
    }
    print "</select>";
}
print "</td><td class='status'>&nbsp;</td><td class='date'>&nbsp;</td><td class='date'>&nbsp;</td><td class='button last'><input type='submit' name='create' value='create'></td></tr>\n";
print_form_table_end();

print "<h4>delete old sessions:</h4>";
print "<form method='post' action='delete_controller.php'><div class='date'>";
print "<label for='session_last_activity_field'>Last Activity Date: <input id='session_last_activity_field' name='session_last_activity' type='date' /></label>";
print "<label for='session_created_field'>Created Date: <input id='session_created_field' name='session_created' type='date' /></label>";
print "<input type='submit' name='delete' value='delete'>";
print "</div></form>";


print "<p><a href='recreate_tables.php'>Recreate Table</a></p>";
print "<p><a href='/secure'>Home</a></p>";

Page::footer();

?>