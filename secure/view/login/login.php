<?php
require_once('login_view_helper.php');

LoginViewHelper::set_headers();

$email = Cookies::get_cookie_value(Cookies::REMEMBER_ME_COOKIE_NAME);
$password = '';

if (Form::is_post()) {
    if (!Cookies::test_cookie_exists()) {
        $GLOBALS['errors']->add('test_cookie', "<strong>ERROR</strong>: Cookies are blocked or not supported by your browser. You must <a href='http://www.google.com/cookies.html'>enable cookies</a> to use this site.");
    }

    $email = Parameters::read_post_input('email');
    $password = Parameters::read_post_input('password');
    $session = Session::create_session($email, $password);
    if (empty($session)) {
        $GLOBALS['errors']->add('authentication_failure', 'Username and password combination incorrect.', 'warning');
    } else if (!$GLOBALS['errors']->has_errors()) {
        // remember user name if successfully logging in
        if (strlen(Parameters::read_post_input('remember_me')) > 0) {
            Cookies::set_cookie(Cookies::REMEMBER_ME_COOKIE_NAME, $email);
        } else {
            Cookies::remove_cookie(Cookies::REMEMBER_ME_COOKIE_NAME);
        }
        Headers::set_redirect_header(LoginViewHelper::redirect_url());
        exit;
    }
}

$check_email = Parameters::read_get_input('check_email');
if (!empty($check_email)) {
    if ($check_email == 'registered') {
        $GLOBALS['errors']->add('registered', 'Registration complete - please check your e-mail for your temporary password.', 'message');
    } elseif ($check_email == 'retrieve_password') {
        $GLOBALS['errors']->add('new_password', 'Please check your e-mail to reset your password', 'message');
    }
}

Page::header('Log In', array('/secure/view/global.css'), '');
?>

<form name="loginform" id="loginform" action="<?php echo LoginViewHelper::login_base_url . 'login.php'; ?>" method="post">

    <input type="hidden" name="redirect_to" value="<?php echo LoginViewHelper::redirect_url(); ?>"/>

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
            <input name="remember_me" type="checkbox" id="remember_me" value="forever" tabindex="90"<?php echo Form::checked(strlen(Cookies::get_cookie_value(Cookies::REMEMBER_ME_COOKIE_NAME)) > 0); ?> />Remember Me
        </label>
    </p>

    <p class="submit">
        <input type="submit" name="submit" id="login-submit" class="button-primary" value="Log In" tabindex="100"/>
    </p>
</form>

<?php
LoginViewHelper::login_footer();
?>