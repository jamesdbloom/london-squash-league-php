<?php
require_once('../../load.php');
load::load_file('view/login', 'login_view_helper.php');

LoginViewHelper::set_headers();

$email = Cookies::get_cookie_value(Cookies::REMEMBER_ME_COOKIE_NAME);
$password = '';

if (Session::has_active_session()) {
    Page::header(Link::Login);
    print "<p>You are already logged in if you want to login as another user please " . Link::get_link(Link::Logout) . " first</p>";
    Page::footer();
    exit;
}

if (Form::is_post()) {
    if (!Cookies::test_cookie_exists()) {
        $GLOBALS['errors']->add('test_cookie', "<strong>ERROR</strong>: Cookies are blocked or not supported by your browser. You must <a href='http://www.google.com/cookies.html'>enable cookies</a> to use this site.");
    }

    $email = Parameters::read_post_input('email');
    $password = Parameters::read_post_input('password');
    $session = Session::create_session($email, $password);
    if (!$GLOBALS['errors']->has_errors()) {
        // remember user name if successfully logging in
        if (strlen(Parameters::read_post_input('remember_me')) > 0) {
            Cookies::set_cookie(Cookies::REMEMBER_ME_COOKIE_NAME, $email);
        } else {
            Cookies::remove_cookie(Cookies::REMEMBER_ME_COOKIE_NAME);
        }
        Headers::set_redirect_header(Urls::get_landing_page() . LoginViewHelper::redirect_url());
        exit;
    }
}

switch (Parameters::read_get_input(LoginViewHelper::message)) {
    case LoginViewHelper::not_logged_in:
        $GLOBALS['errors']->add(LoginViewHelper::not_logged_in, 'Please login to access this page', Error::message);
        break;
    case LoginViewHelper::not_authorised:
        $GLOBALS['errors']->add(LoginViewHelper::not_authorised, 'You are not authorized to view this, please login as administrator', Error::message);
        break;
    case LoginViewHelper::registered:
        $GLOBALS['errors']->add(LoginViewHelper::registered, 'Registration complete - please check your e-mail for your temporary password.', Error::message);
        break;
    case LoginViewHelper::retrieve_password:
        $GLOBALS['errors']->add(LoginViewHelper::retrieve_password, 'Please check your e-mail to reset your password', Error::message);
        break;
}

Page::header(Link::Login);
load::include_file('view/login', 'login_form.php');
Page::footer();
?>