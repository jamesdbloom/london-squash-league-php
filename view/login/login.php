<?php
require_once('../../load.php');
load::load_file('view/login', 'login_view_helper.php');

switch (Parameters::read_request_input(LoginViewHelper::message)) {
    case LoginViewHelper::not_logged_in:
        $GLOBALS['errors']->add(LoginViewHelper::not_logged_in, 'Please login to access this page', Error::message);
        break;
    case LoginViewHelper::session_expired:
        $GLOBALS['errors']->add('expired', 'Your session has expired please log-in again', Error::message);
        break;
    case LoginViewHelper::not_authorised:
        $GLOBALS['errors']->add(LoginViewHelper::not_authorised, 'You are not authorized to view this, please login as administrator', Error::message);
        break;
    case LoginViewHelper::registered:
        $GLOBALS['errors']->add(LoginViewHelper::registered, 'Registration complete - please check your e-mail for your temporary password', Error::message);
        break;
    case LoginViewHelper::retrieve_password:
        $GLOBALS['errors']->add(LoginViewHelper::retrieve_password, 'Please check your e-mail to reset your password', Error::message);
        break;
}


if (Form::is_post()) {
    if (!Cookies::test_cookie_exists()) {
        $GLOBALS['errors']->add('test_cookie', "Cookies are blocked or not supported by your browser. You must <a href='http://www.google.com/cookies.html'>enable cookies</a> to use this site.");
    }

    Cookies::remove_cookie(Session::SSO_ID_COOKIE_NAME);

    $email = Parameters::read_post_input('email');
    $password = Parameters::read_post_input('password');
    if (empty($email)) {
        $GLOBALS['errors']->add('empty_email', 'Please enter an e-mail address');
    }
    if (empty($password)) {
        $GLOBALS['errors']->add('empty_email', 'Please enter a password');
    }

    if (!$GLOBALS['errors']->has_errors()) {
        $session = Session::create_session($email, $password);
    }

    if (!$GLOBALS['errors']->has_errors()) {
        // remember user name if successfully logging in
        if (strlen(Parameters::read_post_input('remember_me')) > 0) {
            Cookies::set_cookie(Cookies::REMEMBER_ME_COOKIE_NAME, $email);
        } else {
            Cookies::remove_cookie(Cookies::REMEMBER_ME_COOKIE_NAME);
        }
        Headers::set_redirect_header(Urls::redirect_url());
        exit;
    }
} else {
    if (Session::has_active_session()) {
        Page::header(Link::Login);
        print "<p class='message'>You are already logged in if you want to login as another user please " . Link::get_link(Link::Logout) . " first</p>";
        Page::footer();
        exit;
    }
}

Page::header(Link::Login);
$message = Parameters::read_request_input(LoginViewHelper::message);
if (empty($message)) {
    // print "<br/><div class='errors_messages'>To improve security I have had to refactor the login code, as a result you will need to reset your password please follow this <a href='https://www.london-squash-league.com/retrieve_password'>link to reset your password</a><br/></div>";
}
load::include_file('view/login', 'login_form.php');
Page::footer();
?>