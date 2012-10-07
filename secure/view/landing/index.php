<html>
<head>
    <title>PHP Test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
require_once('../../load.php');
print '<p>League Administration</p>';
print '<p><a href="/secure/view/league_admin/list_view.php">Manage Leagues</a></p>';
print '<p>User Administration</p>';
print '<p><a href="/secure/view/user_admin/list_view.php">Manage Users & Sessions</a></p>';
print '<p>Page Flows</p>';
print '<p><a href="/secure/view/login/login.php">Login</a></p>';
if(Session::has_active_session()) {
    print '<p><a href="/secure/view/login/logout.php">Logout</a></p>';
    print '<p><a href="/secure/view/login/reset_password.php">Update Password</a></p>';
}
?>

</body>
</html>