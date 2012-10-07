<?php
require_once('../../load.php');
load::load_file('view/admin', 'user_imports.php');

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