<?php
require_once('../../load.php');
load::load_file('view/user_admin', 'user_imports.php');

if (Parameters::read_post_input('yes') == 'yes') {

    UserDAO::create_user_schema();
    SessionDAO::create_session_schema();

    Footer::outputUserAdminFooter();

} else {

    Headers::set_redirect_header(Link::root . Link::User_Admin_Url);

}
?>