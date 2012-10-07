<?php
include '../admin/league_imports.php';
require_once('../admin/user_footer.php');

UserDAO::create_user_schema();
SessionDAO::create_session_schema();

Footer::outputFooter();
?>