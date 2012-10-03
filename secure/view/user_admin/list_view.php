<?php
include '../admin/user_header.php';
?>
<!DOCTYPE>
<html>
<head>
    <title>Administration</title>
    <link rel="stylesheet" type="text/css" href="/secure/view/admin/admin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php

//
// READ DATABASE DATA
//
$user_list = UserDAO::get_all($errors);
$session_list = SessionDAO::get_all($errors);
Error::print_errors($errors);
$user_map = list_to_map($user_list);

//
// USERS
//
print "<h2>Users</h2>";
print "<table>\n";
print "<tr><th class='id'>Id</th><th class='name'>Name</th><th class='email'>Email</th><th class='mobile'>Mobile</th><th class='button'></th></tr>\n";
foreach ($user_list as $user) {
    print "<form method='post' action='delete_controller.php'>\n";
    print "<input name='user_id' type='hidden' value='" . $user->id . "'>\n";
    print "<tr><td class='id'>$user->id</td><td class='name'>$user->name</td><td class='email'>$user->email</td><td class='mobile'>$user->mobile</td><td class='button'><input type='submit' name='delete' value='delete'></td></tr>\n";
    print "</form>\n";
}
print "<form method='post' action='create_controller.php'>\n";
print "<input name='type' type='hidden' value='user'>\n";
print "<tr><td class='id'></td><td class='name'><input name='name' type='text' pattern='.{3,25}' required='required'></td><td class='email'><input name='email' type='email' pattern=\"[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\" required='required'></td><td class='mobile'><input name='mobile' type='tel' pattern='\d{5,25}' required='required'></td><td class='button'><input type='submit' name='create' value='create'></td></tr>\n";
print "</form>\n";
print "</table>\n";

//
// SESSIONS
//
print "<h2>Sessions</h2>";
print "<table>\n";
print "<tr><th class='session'>Id</th><th class='name'>User</th><th class='status'>Status</th><th class='date'>Created</th><th class='date'>Last Activity</th><th class='button'></th></tr>\n";
foreach ($session_list as $session) {
    $user = $user_map[$session->user_id];
    print "<form method='post' action='delete_controller.php'>\n";
    print "<input name='session_id' type='hidden' value='" . $session->id . "'>\n";
    print "<tr><td class='session'>$session->id</td><td class='name'>" . (!empty($user) ? $user->name : $session->user_id ) . "</td><td class='status'>$session->status</td><td class='date'>$session->created_date</td><td class='date'>$session->last_activity_date</td><td class='button'><input type='submit' name='delete' value='delete'></td></tr>\n";
    print "</form>\n";
}
print "<form method='post' action='create_controller.php'>\n";
print "<input name='type' type='hidden' value='session'>\n";
print "<tr><td class='session'></td><td class='name'>";
if (count($user_list) > 0) {
    print "<select name='user_id'>";
    foreach ($user_list as $user) {
        print "<option value='" . $user->id . "''>$user->name</option>\n";
    }
    print "</select>";
}
print "</td><td class='status'></td><td class='date'></td><td class='date'></td><td class='button'><input type='submit' name='create' value='create'></td></tr>\n";
print "</form>\n";
print "</table>\n";

print "<p><a href='recreate_tables.php'>Recreate Table</a></p>";
print "<p><a href='/secure'>Home</a></p>";

function list_to_map($list) {
    $map = array();
    foreach ($list as $list_item) {
        $map[$list_item->id] = $list_item;
    }
    return $map;
}
?>
</body>
</html>