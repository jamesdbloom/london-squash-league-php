<?php
require_once('../../load.php');
load::load_file('domain/session', 'sessionDAO.php');
?>
<?php
$errors = new Error();
$id = Parameters::read_post_input('id');
$user_id = Parameters::read_post_input('user_id');
if (!empty($id)) {
    $session = SessionDAO::get_by_id($id, $errors);
} else if (!empty($user_id)) {
    $session = SessionDAO::get_by_user_id($user_id, $errors);
}
if ($errors->has_errors()) {
    echo $errors;
}
if (!empty($session)) {
    print "<table border='1'>\n";
    print "<tr><th>Id</td><td>User Id</td><td>Status</td><td>Created Date</td><td>Last Activity date</td></tr>\n";
    print "<tr><td>$session->id</td><td>$session->user_id</td><td>$session->status</td><td>$session->created_date</td><td>$session->last_activity_date</td></tr>\n";
    print "</table>\n";
}
include '../layout/footer/footer.php';
?>