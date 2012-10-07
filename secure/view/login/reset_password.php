<?php
require_once('login_view_helper.php');

LoginViewHelper::set_headers();

$key = rawurldecode(Parameters::read_get_input('key'));
$email = rawurldecode(Parameters::read_get_input('email'));
$user = Authentication::check_password_activation_key($key, $email);

if (empty($user)) {
    Headers::set_redirect_header(LoginViewHelper::login_base_url . 'retrieve_password.php?error=invalidkey');
}

if (Form::is_post()) {
    $password_one = Parameters::read_post_input('password_one');
    $password_two = Parameters::read_post_input('password_two');
    UserDAO::update_activation_key($email, '');
    if (!empty($password_one) && $password_one != $password_two) {
        $GLOBALS['errors']->add('password_reset_mismatch', 'The passwords do not match.');
    } else {
        UserDAO::update_password($email, $password_one);

        $message = 'Password Lost and Changed for user: ' . $email . '\r\n';
        Email::send_email(Urls::get_webmaster_email(), PageSearchTerms::site_title . ' Password Lost/Changed', $message);
    }

    if (!$GLOBALS['errors']->has_errors()) {
        Page::header('Password Reset', array('/secure/view/global.css'), "<p class='message reset-pass'>Your password has been reset <a href='" . LoginViewHelper::login_base_url . "login.php'>Log in</a></p>");
        LoginViewHelper::login_footer();
        exit;
    }
}

Page::header('Reset Password', array('/secure/view/global.css'), '<p class="message reset-pass">' . 'Enter your new password below.' . '</p>');
?>

<form name="reset_password_form" id="reset_password_form" action="<?php echo LoginViewHelper::login_base_url . 'reset_password.php?key=' . rawurlencode($key) . '&email=' . rawurlencode($email); ?>" method="post">
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
?>