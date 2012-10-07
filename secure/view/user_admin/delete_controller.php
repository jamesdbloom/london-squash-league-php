<?php
include '../admin/user_imports.php';
require_once('../admin/user_footer.php');

$user_id = Parameters::read_post_input('user_id');
$session_id = Parameters::read_post_input('session_id');

if (!empty($user_id)) {
    UserDAO::delete_by_id($user_id);
}
if (!empty($session_id)) {
    SessionDAO::delete_by_id($session_id);
}

Footer::outputFooter();
?>