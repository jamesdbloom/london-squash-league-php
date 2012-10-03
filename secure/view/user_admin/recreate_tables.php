<?php
include '../admin/league_header.php';
require_once('../admin/user_footer.php');

UserDAO::create_user_schema($errors);
SessionDAO::create_session_schema($errors);

Footer::outputFooter($errors);
?>