<?php
require_once('../../load.php');
load::load_file('domain/user', 'userDAO.php');
load::load_file('domain/session', 'sessionDAO.php');

class LoginViewHelper
{
    const login_base_url = '/secure/view/login/';

    public static function set_headers()
    {
        Headers::set_nocache_headers();
        Headers::set_content_type_header();
        Cookies::set_test_cookie();
    }

    public static function login_footer()
    {
        Page::footer(array(
            array(self::login_base_url . 'login.php', 'Login'),
            array(self::login_base_url . 'register.php', 'Register'),
            array(self::login_base_url . 'retrieve_password.php', 'Lost password?')
        ));
    }

    public static function redirect_url()
    {
        return Urls::escape_and_sanitize_attribute_value(Parameters::read_request_input('redirect_to', "https://" . $_SERVER["SERVER_NAME"]));
    }

    public static function validate_and_create_user($human_name, $email, $mobile)
    {
        // Check the human_name
        if ($human_name == '') {
            $GLOBALS['errors']->add('empty_human_name', '<strong>ERROR</strong>: Please enter your name.');
        } elseif (!InputValidation::is_valid_human_name($human_name)) {
            $GLOBALS['errors']->add('invalid_human_name', '<strong>ERROR</strong>: The name is invalid because it uses characters that are not allowed.');
        }

        // Check the e-mail address
        if ($email == '') {
            $GLOBALS['errors']->add('empty_email', '<strong>ERROR</strong>: Please type your e-mail address.');
        } elseif (!InputValidation::is_valid_email_address($email)) {
            $GLOBALS['errors']->add('invalid_email', '<strong>ERROR</strong>: The email address isn&#8217;t correct.');
            $email = '';
        } elseif (UserDAO::email_already_registered($email)) {
            $GLOBALS['errors']->add('email_exists', '<strong>ERROR</strong>: This email is already registered, please choose another one.');
        }

        if (!$GLOBALS['errors']->has_errors()) {
            $password = Authentication::generate_password(12, true);
            $user = UserDAO::create($human_name, $password, $email, $mobile, Authentication::generate_password(20, true));
            if (empty($user)) {
                $GLOBALS['errors']->add('registerfail', sprintf('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact <a href="mailto:%s">%s</a>', Urls::get_webmaster_email(), Urls::get_webmaster_email()));
            } else {
                self::send_new_user_notification($user, $password);
                return $user;
            }
        }
        return null;
    }

    public static function send_new_user_notification(User $user, $password)
    {
        $title = PageSearchTerms::site_title . ' User Registration';
        $login_page_url = Urls::get_root_url() . self::login_base_url;
        $message = '
            <p>Someone registered an account associated to this email address.</p>
            <p>If this was a mistake, just ignore this email and nothing will happen.</p>
            <p>To login to you account using the details below on the login page: <a href="' . $login_page_url . '">' . $login_page_url . '</a></p>
            <p>Username: ' . $user->email . '</p>
            <p>Password: ' . $password . '</p>
        ';

        Email::send_email($user->email, $title, $message);
    }

    public static function validate_email_and_retrieve_user($email)
    {
        $user = null;
        if (empty($email)) {
            $GLOBALS['errors']->add('empty_email', '<strong>ERROR</strong>: Enter an e-mail address.');
        } else if (InputValidation::is_valid_email_address($email)) {
            $user = UserDAO::get_by_email($email);
            if (empty($user)) {
                $GLOBALS['errors']->add('invalid_email', '<strong>ERROR</strong>: Please enter a valid e-mail address.');
            }
        } else {
            $GLOBALS['errors']->add('invalid_email', '<strong>ERROR</strong>: Please enter a valid e-mail address.');
        }
        return $user;
    }
}

?>