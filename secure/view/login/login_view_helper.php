<?php
require_once('../../load.php');
load::load_file('domain/user', 'userDAO.php');
load::load_file('domain/session', 'sessionDAO.php');

class LoginViewHelper
{
    const login_url = '/secure/view/login/login.php';
    const REMEMBER_ME_COOKIE_NAME = 'remember_me';

    public static function determine_action()
    {
        $action = Parameters::read_request_input('action', 'login');

        $key = Parameters::read_get_input('key');
        if (!empty($key)) {
            $action = 'reset_password';
        }

        if (!in_array($action, array('logout', 'retrieve_password', 'reset_password', 'register', 'login'), true)) {
            $action = 'login';
        }

        return $action;
    }

    public static function login_footer()
    {
        Page::footer(array(
            array(self::login_url, 'Login'),
            array(self::login_url . '?action=register', 'Register'),
            array(self::login_url . '?action=retrieve_password', 'Lost password?')
        ));
    }

    public static function register_new_user($human_name, $email, $mobile)
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
        $login_page_url = Urls::get_root_url() . self::login_url;
        $message = '
            <p>Someone registered an account associated to this email address.</p>
            <p>If this was a mistake, just ignore this email and nothing will happen.</p>
            <p>To login to you account using the details below on the login page: <a href="' . $login_page_url . '">' . $login_page_url . '</a></p>
            <p>Username: ' . $user->email . '</p>
            <p>Password: ' . $password . '</p>
        ';

        Email::send_email($user->email, $title, $message);
    }

    public static function send_password_retrieval_email($email)
    {
        if (empty($email)) {
            $GLOBALS['errors']->add('empty_email', '<strong>ERROR</strong>: Enter an e-mail address.');
        } else if (InputValidation::is_valid_email_address($email)) {
            $user = UserDAO::get_by_email($email);
            if (empty($user)) {
                $GLOBALS['errors']->add('invalid_email', '<strong>ERROR</strong>: There is no user registered with that email address.');
            }
        } else {
            $GLOBALS['errors']->add('invalid_email', '<strong>ERROR</strong>: Please enter a valid e-mail address.');
        }

        if (!$GLOBALS['errors']->has_errors() && !empty($user)) {
            // ensures email in correct case
            $database_email = $user->email;

            $allow = Authentication::allow_password_reset($database_email);

            if ($allow && !$GLOBALS['errors']->has_errors()) {
                $key = UserDAO::get_activation_key($database_email);
                if (empty($key)) {
                    // Generate something random for a key...
                    $key = Authentication::generate_password(20);
                    // Now insert the new md5 key into the db
                    UserDAO::update_activation_key($database_email, $key);
                }

                $title = PageSearchTerms::site_title . ' Password Reset';
                $reset_url = Urls::get_root_url() . self::login_url . "?action=reset_password&key=" . rawurlencode($key) . "&email=" . rawurlencode($database_email);
                $message = '
                    <p>Someone requested that the password be reset for the account associated to this email address.</p>
                    <p>If this was a mistake, just ignore this email and nothing will happen.</p>
                    <p>To reset your password, visit the following address <a href="' . $reset_url . '">' . $reset_url . '</a></p>
                ';

                return Email::send_email($database_email, $title, $message);
            }
        }
        return false;
    }

    public static function reset_password($email, $password_one, $password_two)
    {
        UserDAO::update_activation_key($email, '');
        if (!empty($password_one) && $password_one != $password_two) {
            $GLOBALS['errors']->add('password_reset_mismatch', 'The passwords do not match.');
        } else {
            UserDAO::update_password($email, $password_one);

            $message = 'Password Lost and Changed for user: ' . $email . '\r\n';
            Email::send_email(Urls::get_webmaster_email(), PageSearchTerms::site_title . ' Password Lost/Changed', $message);
        }
    }
}

?>