<?php
include '../admin/user_imports.php';
require_once('../admin/user_footer.php');
require_once('../login/login_view_helper.php');

$type = Parameters::read_post_input('type');
if ($type == 'user') {
    $password = Authentication::generate_password(12, true);
    $user = UserDAO::create(
        Parameters::read_post_input('name'),
        $password,
        Parameters::read_post_input('email'),
        Parameters::read_post_input('mobile'),
        Authentication::generate_password(20, true)
    );
    if (!$GLOBALS['errors']->has_errors()) {
        LoginViewHelper::send_new_user_notification($user, $password);
    }
}
if ($type == 'session') {
    SessionDAO::create(
        Session::generate_session_id(Parameters::read_post_input('user_id')),
        Parameters::read_post_input('user_id')
    );
}

Footer::outputFooter();

function is_validate_inputs($password_check, $password)
{
    if ($password_check == $password) {
        return true;
    } else {
        $GLOBALS['errors']->add('password_error', "The password do not match please try again");
    }
}

?>