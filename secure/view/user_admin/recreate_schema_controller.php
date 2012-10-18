<?php
require_once('../../load.php');
load::load_file('view/user_admin', 'user_imports.php');

UserDAO::create_user_schema();
SessionDAO::create_session_schema();

Footer::outputFooter();
?>