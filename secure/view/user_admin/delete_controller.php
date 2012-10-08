<?php
require_once('../../load.php');
load::load_file('view/admin', 'user_imports.php');

$user_id = Parameters::read_post_input('user_id');
$session_id = Parameters::read_post_input('session_id');
$session_last_activity = Parameters::read_post_input('session_last_activity');
$session_created = Parameters::read_post_input('session_created');

if (!empty($user_id)) {
    UserDAO::delete_by_id($user_id);
}
if (!empty($session_id)) {
    SessionDAO::delete_by_id($session_id);
}
if (!empty($session_last_activity)) {
    SessionDAO::delete_by_last_activity($session_last_activity);
}
if (!empty($session_created)) {
    SessionDAO::delete_by_created_date($session_created);
}

Footer::outputFooter();
?>