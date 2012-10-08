<html>
<head>
    <title>PHP Test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<p>League Administration</p>

<p><a href="/secure/view/league/view.php">Manage Leagues</a></p>

<p>User Administration</p>

<p><a href="/secure/view/authentication/view.php">Manage Users & Sessions</a></p>

<p>Page Flows</p>
<?php
require_once('../../load.php');
if (Session::has_active_session()) {
    print '<p><a href="/secure/view/account/view.php">Account Settings</a></p>';
    print '<p><a href="/secure/view/login/reset_password.php">Update Password</a></p>';
    print '<p><a href="/secure/view/login/logout.php">Logout</a></p>';
} else {
    print '<p><a href="/secure/view/login/login.php">Login</a></p>';
}
?>
</body>
</html>