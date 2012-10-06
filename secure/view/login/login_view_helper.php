<?php
require_once('../../load.php');
load::load_file('domain/user', 'userDAO.php');
load::load_file('domain/session', 'sessionDAO.php');

class LoginViewHelper
{
    const login_url = '/secure/view/login/login.php';
    const HASH_COOKIE_NAME = 'cookie_hash';
    const REMEMBER_ME_COOKIE_NAME = 'remember_me';

    public static function login_header($title = 'Log In', $message = '', $errors = '')
    {
        ?><!DOCTYPE>
        <html xmlns="http://www.w3.org/1999/xhtml" lang="en">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo PageSearchTerms::site_title; ?> &rsaquo; <?php echo $title; ?></title>
            <?php

            $login_header_url = "https://" . $_SERVER["SERVER_NAME"];

            ?>
            <link rel="stylesheet" type="text/css" href="/secure/view/global.css">
        </head>
        <body class="login">
        <div id="login">
            <h1>
                <p>
                    <a href="<?php echo Urls::escape_and_sanitize_url($login_header_url); ?>" title="<?php echo PageSearchTerms::site_title; ?>"><?php echo PageSearchTerms::site_title; ?></a>
                </p>
            </h1>
        <h2><?php echo $title; ?></h2>
        <?php

        if (!empty($message))
            echo $message . "\n";

        global $errors;

        if (empty($errors)) {
            $errors = new Error();
        } else {
            Error::print_errors($errors);
        }
    }

    public static function login_footer($scripts = '')
    {
        ?>
        <p id="nav">
            <a href="<?php echo self::login_url; ?>">Login</a> |
            <a href="<?php echo self::login_url . '?action=logout'; ; ?>">Logout</a> |
            <a href="<?php echo self::login_url . '?action=register'; ?>">Register</a> |
            <a href="<?php echo self::login_url . '?action=retrieve_password'; ?>" title="Password Lost and Found">Lost your password?</a>
        </p>

        </div>

        <div class="clear"></div>
        <?php echo $scripts; ?>
        </body>
        </html>
        <?php
    }

    public static function register_new_user($human_name, $email, $mobile, Error $errors)
    {
        // Check the human_name
        if ($human_name == '') {
            $errors->add('empty_human_name', '<strong>ERROR</strong>: Please enter your name.');
        } elseif (!InputValidation::is_valid_human_name($human_name)) {
            $errors->add('invalid_human_name', '<strong>ERROR</strong>: The name is invalid because it uses characters that are not allowed.');
        }

        // Check the e-mail address
        if ($email == '') {
            $errors->add('empty_email', '<strong>ERROR</strong>: Please type your e-mail address.');
        } elseif (!InputValidation::is_valid_email_address($email)) {
            $errors->add('invalid_email', '<strong>ERROR</strong>: The email address isn&#8217;t correct.');
            $email = '';
        } elseif (UserDAO::email_already_registered($email, $errors)) {
            $errors->add('email_exists', '<strong>ERROR</strong>: This email is already registered, please choose another one.');
        }

        if (!$errors->has_errors()) {
            $password = Authentication::generate_password(12, true);
            $user = UserDAO::create($human_name, $password, $email, $mobile, Authentication::generate_password(20, true), $errors);
            if (empty($user)) {
                $errors->add('registerfail', sprintf('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact <a href="mailto:%s">%s</a>', Urls::get_webmaster_email(), Urls::get_webmaster_email()));
            } else {
                self::send_new_user_notification($user, $password, $errors);
                return $user;
            }
        }
        return null;
    }

    public static function send_new_user_notification(User $user, $password, Error $errors)
    {
        $title = PageSearchTerms::site_title . ' User Registration';
        $login_page_url = Urls::get_root_url() . self::login_url;
        $message = '
            <html>
            <head>
              <title>' . $title . '</title>
            </head>
            <body>
              <p>Someone registered an account associated to this email address.</p>
              <p>If this was a mistake, just ignore this email and nothing will happen.</p>
              <p>To login to you account using the details below on the login page: <a href="' . $login_page_url . '">' . $login_page_url . '</a></p>
              <p>Username: ' . $user->email . '</p>
              <p>Password: ' . $password . '</p>
            </body>
            </html>
            ';

        Email::send_email($user->email, $title, $message, $errors);
    }

    public static function send_password_retrieval_email($email, Error $errors)
    {
        if (empty($email)) {
            $errors->add('empty_email', '<strong>ERROR</strong>: Enter an e-mail address.');
        } else if (InputValidation::is_valid_email_address($email)) {
            $user = UserDAO::get_by_email($email, $errors);
            if (empty($user)) {
                $errors->add('invalid_email', '<strong>ERROR</strong>: There is no user registered with that email address.');
            }
        } else {
            $errors->add('invalid_email', '<strong>ERROR</strong>: Please enter a valid e-mail address.');
        }

        if (!$errors->has_errors() && !empty($user)) {
            // ensures email in correct case
            $database_email = $user->email;

            $allow = Authentication::allow_password_reset($database_email, $errors);

            if ($allow && !$errors->has_errors()) {
                $key = UserDAO::get_activation_key($database_email, $errors);
                if (empty($key)) {
                    // Generate something random for a key...
                    $key = Authentication::generate_password(20);
                    // Now insert the new md5 key into the db
                    UserDAO::update_activation_key($database_email, $key, $errors);
                }

                $title = PageSearchTerms::site_title . ' Password Reset';
                $reset_url = Urls::get_root_url() . self::login_url . "?action=reset_password&key=" . rawurlencode($key) . "&email=" . rawurlencode($database_email);
                $message = '
                <html>
                <head>
                  <title>' . $title . '</title>
                </head>
                <body>
                  <p>Someone requested that the password be reset for the account associated to this email address.</p>
                  <p>If this was a mistake, just ignore this email and nothing will happen.</p>
                  <p>To reset your password, visit the following address <a href="' . $reset_url . '">' . $reset_url . '</a></p>
                </body>
                </html>
                ';

                return Email::send_email($database_email, $title, $message, $errors);
            }
        }
        return false;
    }

    public static function reset_password($email, $new_password, Error $errors)
    {
        UserDAO::update_password($email, $new_password, $errors);

        $message = 'Password Lost and Changed for user: ' . $email . '\r\n';
        Email::send_email(Urls::get_webmaster_email(), PageSearchTerms::site_title . ' Password Lost/Changed', $message, $errors);
    }

    public static function determine_action()
    {
        $action = Parameters::read_request_input('action', 'login');

        $key = Parameters::read_get_input('key');
        if (!empty($key)) {
            $action = 'reset_password';
        }

        if (!in_array($action, array('postpass', 'logout', 'retrieve_password', 'reset_password', 'register', 'login'), true)) {
            $action = 'login';
        }

        return $action;
    }

    public static function remove_all_cookies()
    {
        Cookies::remove_cookie(self::HASH_COOKIE_NAME);
        Cookies::remove_cookie(Session::SSO_ID_COOKIE_NAME);
    }
}

?>