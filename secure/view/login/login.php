<?php
require_once('../../load.php');
load::load_file('domain/user', 'userDAO.php');
load::load_file('domain/session', 'sessionDAO.php');
require_once('login_view_helper.php');

//
// START Main Page Control
//

$action = LoginViewHelper::determine_action();

Headers::set_nocache_headers();
Headers::set_content_type_header();
Cookies::set_test_cookie();

$is_http_post = ('POST' == $_SERVER['REQUEST_METHOD']);

switch ($action) {

    case 'logout' :
        Session::logout();
        Cookies::remove_cookie(Session::SSO_ID_COOKIE_NAME);

        Headers::redirect_to_root();

        break;

    case 'retrieve_password' :
        $redirect_to = Parameters::read_request_input('redirect_to', LoginViewHelper::login_url);

        if ($is_http_post) {
            $email = Parameters::read_post_input('email');
            LoginViewHelper::send_password_retrieval_email($email);

            if (!$GLOBALS['errors']->has_errors()) {
                Headers::set_redirect_header(LoginViewHelper::login_url . "?check_email=retrieve_password");
                break;
            }
        }

        $error = Parameters::read_request_input('error');
        if ($error == 'invalidkey') {
            $GLOBALS['errors']->add('invalidkey', 'Sorry, that key does not appear to be valid.', 'error');
        }

        Page::header('Lost Password', array('/secure/view/global.css'), '<p class="message">' . 'Please enter your email address. You will receive a link to create a new password via email.' . '</p>');

        $email = Parameters::read_post_input('email');

        ?>

        <form name="retrieve_password_form" id="retrieve_password_form" action="<?php LoginViewHelper::login_url ?>?action=retrieve_password" method="post">
            <p>
                <label for="email">E-mail:<br/>
                    <input type="email" name="email" id="email" class="input" value="<?php echo Urls::escape_and_sanitize_attribute_value($email); ?>" size="35" required="required"
                           pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?" tabindex="10"/>
                </label>
            </p>
            <input type="hidden" name="redirect_to" value="<?php echo Urls::escape_and_sanitize_attribute_value($redirect_to); ?>"/>

            <p class="submit">
                <input type="submit" name="submit" class="button-primary" value="Get New Password" tabindex="100"/>
            </p>
        </form>

        <?php
        LoginViewHelper::login_footer();
        break;

    case 'reset_password' :
        $key = rawurldecode(Parameters::read_get_input('key'));
        $email = rawurldecode(Parameters::read_get_input('email'));

        $user = Authentication::check_password_activation_key($key, $email);

        if (empty($user)) {
            Headers::set_redirect_header(LoginViewHelper::login_url . '?action=retrieve_password&error=invalidkey');
        }

        if ($is_http_post) {
            LoginViewHelper::reset_password($email, Parameters::read_post_input('password_one'), Parameters::read_post_input('password_two'));
            if (!$GLOBALS['errors']->has_errors()) {
                Page::header('Password Reset', array('/secure/view/global.css'), '<p class="message reset-pass">' . 'Your password has been reset ' . ' <a href="' . LoginViewHelper::login_url . '">' . 'Log in' . '</a></p>');
                LoginViewHelper::login_footer();
                break;
            }
        }

        Page::header('Reset Password', array('/secure/view/global.css'), '<p class="message reset-pass">' . 'Enter your new password below.' . '</p>');

        ?>
        <form name="reset_password_form" id="reset_password_form" action="<?php echo LoginViewHelper::login_url . '?action=reset_password&key=' . rawurlencode($key) . '&email=' . rawurlencode($email); ?>" method="post">
            <input type="hidden" name="email" value="<?php echo Urls::escape_and_sanitize_attribute_value(Parameters::read_post_input('email')); ?>" autocomplete="off"/>

            <p>
                <label for="password_one">New password<br/>
                    <input type="password" name="password_one" id="password_one" class="input" size="35" required="required" pattern="^.{2,10}\b(\£|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\_|\[|\]|\{|\}|\<|\>|\~|\`|\+|\=|\,|\.|\;|\:|\/|\?|\|)\b.{2,10}$" value="" autocomplete="off"
                           tabindex="10"/>
                </label>
            </p>

            <p>
                <label for="password_two">Confirm new password<br/>
                    <input type="password" name="password_two" id="password_two" class="input" size="35" required="required" pattern="^.{2,10}\b(\£|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\_|\[|\]|\{|\}|\<|\>|\~|\`|\+|\=|\,|\.|\;|\:|\/|\?|\|)\b.{2,10}$" value="" autocomplete="off"
                           tabindex="20"
                           onkeyup="if(this.value == document.getElementById('password_one').value) { this.setAttribute('class', 'input'); } else { this.setAttribute('class', 'password-no-match input'); }"/>
                </label>
            </p>

            <p class="description indicator-hint">Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp;</p>

            <br class="clear"/>

            <p class="submit">
                <input type="submit" name="submit" class="button-primary" value="Reset Password" tabindex="100"/>
            </p>
        </form>

        <?php
        LoginViewHelper::login_footer();
        break;

    case 'register' :
        $human_name = '';
        $email = '';
        $mobile = '';
        $redirect_to = Parameters::read_post_input('redirect_to', LoginViewHelper::login_url);

        if ($is_http_post) {
            $human_name = Parameters::read_post_input('human_name');
            $email = Parameters::read_post_input('email');
            $mobile = Parameters::read_post_input('mobile');
            LoginViewHelper::register_new_user($human_name, $email, $mobile);
            $redirect_to = LoginViewHelper::login_url . "?check_email=registered";

            if (!$GLOBALS['errors']->has_errors()) {
                Headers::set_redirect_header($redirect_to);
                break;
            }
        }

        Page::header('New User Registration', array('/secure/view/global.css'), '<p class="message register">' . 'Please enter your details and a temporary password will be e-mailed to you.' . '</p>');

        ?>

        <form name="registerform" id="registerform" action="<?php echo LoginViewHelper::login_url . '?action=register'; ?>" method="post">
            <p>
                <label for="human_name">Name<br/>
                    <input type="text" name="human_name" id="human_name" class="input" value="<?php echo Urls::escape_and_sanitize_attribute_value($human_name); ?>" size="35" required="required" pattern=".{3,25}" tabindex="10"/>
                </label>
            </p>

            <p>
                <label for="email">E-mail<br/>
                    <input type="email" name="email" id="email" class="input" value="<?php echo Urls::escape_and_sanitize_attribute_value($email); ?>" size="35" required="required"
                           pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?" tabindex="20"/>
                </label>
            </p>

            <p>
                <label for="mobile">Mobile (optional - if provided shown to league members in your division)<br/>
                    <input type="tel" name="mobile" id="mobile" class="input" value="<?php echo Urls::escape_and_sanitize_attribute_value($mobile); ?>" size="35" pattern="\d{5,25}" tabindex="30"/>
                </label>
            </p>

            <input type="hidden" name="redirect_to" value="<?php echo Urls::escape_and_sanitize_attribute_value($redirect_to); ?>"/>

            <p class="submit">
                <input type="submit" name="submit" class="button-primary" value="Register" tabindex="100"/>
            </p>
        </form>

        <?php
        LoginViewHelper::login_footer();
        break;

    case 'login' :
    default:

        // todo handle redirecting back to referer page
        $redirect_to = Parameters::read_request_input('redirect_to', Urls::get_root_url());

        $email = Parameters::read_post_input('email');
        $password = Parameters::read_post_input('password');

        $check_email = Parameters::read_get_input('check_email');
        if (!empty($check_email)) {
            if ($check_email == 'registered') {
                $GLOBALS['errors']->add('registered', 'Registration complete - please check your e-mail for your temporary password.', 'message');
            } elseif ($check_email == 'retrieve_password') {
                $GLOBALS['errors']->add('new_password', 'Please check your e-mail to reset your password', 'message');
            }
        } else if (!empty($email) && !empty($password)) {
            $session = Session::create_session($email, $password);
            if (empty($session)) {
                $GLOBALS['errors']->add('authentication_failure', 'Username and password combination incorrect.', 'warning');
            }
        }

        $remember_me = strlen(Parameters::read_post_input('remember_me')) > 0;

        if ($is_http_post) {
            // If cookies are disabled we can't log in even with a valid user+pass
            $test_cookie = Cookies::get_test_cookie();

            if (empty($test_cookie)) {
                $GLOBALS['errors']->add('test_cookie', "<strong>ERROR</strong>: Cookies are blocked or not supported by your browser. You must <a href='http://www.google.com/cookies.html'>enable cookies</a> to use this site.");
            }

            if (!$remember_me) {
                Cookies::remove_cookie(LoginViewHelper::REMEMBER_ME_COOKIE_NAME);
            }
        }

        if (!$GLOBALS['errors']->has_errors() && !empty($session)) {
            if ($remember_me) {
                Cookies::set_cookie(LoginViewHelper::REMEMBER_ME_COOKIE_NAME, $email);
            }
            Headers::set_redirect_header($redirect_to);
            break;
        }

        if (empty($email)) {
            $email = Cookies::get_cookie_value(LoginViewHelper::REMEMBER_ME_COOKIE_NAME);
        }

        Page::header('Log In', array('/secure/view/global.css'), '');

        ?>

        <form name="loginform" id="loginform" action="<?php echo LoginViewHelper::login_url; ?>" method="post">

            <input type="hidden" name="redirect_to" value="<?php echo Urls::escape_and_sanitize_attribute_value($redirect_to); ?>"/>

            <p>
                <label for="email">E-mail<br/>
                    <input type="email" name="email" id="email" class="input" value="<?php echo Urls::escape_and_sanitize_attribute_value($email); ?>" size="35" required="required"
                           pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?" tabindex="10"/>
                </label>
            </p>

            <p>
                <label for="password">Password<br/>
                    <input type="password" name="password" id="password" class="input" value="" size="35" required="required" tabindex="20"/>
                </label>
            </p>

            <p>
                <label for="remember_me">
                    <input name="remember_me" type="checkbox" id="remember_me" value="forever" tabindex="90"<?php echo Form::checked(strlen(Cookies::get_cookie_value(LoginViewHelper::REMEMBER_ME_COOKIE_NAME)) > 0); ?> />Remember Me
                </label>
            </p>

            <p class="submit">
                <input type="submit" name="submit" id="login-submit" class="button-primary" value="Log In" tabindex="100"/>
            </p>
        </form>

        <?php
        LoginViewHelper::login_footer();
        break;
}
//
// END Main Page Control
//

?>