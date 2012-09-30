<?php
require_once('../../load.php');
load::load_file('domain/session', 'session.php');
load::load_file('domain/session', 'sessionDAO.php');
?>

<html>
<head>
    <title>Sessions List</title>
</head>
<body>
<?php
$errors = new Error();
$session_list = SessionDAO::get_all($errors);
if ($errors->has_errors()) {
    echo $errors;
}
if (count($session_list) > 0) {
    print "<table border='1'>\n";
    print "<tr><th>Id</td><td>User Id</td><td>Status</td><td>Created Date</td><td>Last Activity date</td></tr>\n";
    foreach ($session_list as $session)
        print "<tr><td>$session->id</td><td>$session->user_id</td><td>$session->status</td><td>$session->created_date</td><td>$session->last_activity_date</td></tr>\n";
    print "</table>\n";
}
include '../layout/footer/footer.php';
?>
</body>
</html>