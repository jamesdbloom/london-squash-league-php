<?php
require_once('../../load.php');
load::load_file('view/login', 'login_view_helper.php');

LoginViewHelper::set_headers();

$key = rawurldecode(Parameters::read_get_input('key'));
if (!empty($key)) {
    $email = rawurldecode(Parameters::read_get_input('email'));
    $user = Authentication::check_password_activation_key($key, $email);
    if (empty($user)) {
        Headers::set_redirect_header(Link::Retrieve_Password_Url . '?error=invalidkey');
    }
} else {
    $user = Session::get_user();
    if (empty($user)) {
        Headers::redirect_to_login(LoginViewHelper::not_logged_in);
    }
}

if (Form::is_post()) {
    $password_one = Parameters::read_post_input('password_one');
    $password_two = Parameters::read_post_input('password_two');
    if (!empty($email)) {
        UserDAO::update_activation_key($email, '');
    }
    if (!empty($password_one) && $password_one != $password_two) {
        $GLOBALS['errors']->add('password_reset_mismatch', 'The passwords do not match.');
    } else {
        UserDAO::update_password($email, $password_one);

        $message = 'Password Lost and Changed for user: ' . $email . '\r\n';
        Email::send_email(Urls::get_webmaster_email(), PageSearchTerms::site_title . ' Password Lost/Changed', $message);
    }

    if (!$GLOBALS['errors']->has_errors()) {
        Page::header(Link::Update_Password, array(), '', "Your password has been reset " . Link::get_link(Link::Login));
        Page::footer();
        exit;
    }
}

Page::header(Link::Update_Password, array(), '', "Enter your new password below.");
?>

<form action='<?php echo Link::Reset_Password_Url . '?key=' . rawurlencode($key) . '&email=' . rawurlencode($email); ?>' method='post'>
    <input type="hidden" name="email" value="<?php echo Urls::escape_and_sanitize_attribute_value(Parameters::read_post_input('email')); ?>"/>

    <div class="reset_password_form">
        <p>
            <label class='password' for="password_one">Password:</label>
            <input class='show_validation' type="password" name="password_one" id="password_one" class="input" autocorrect=”off” autocapitalize=”off” autocomplete=”off” required="required"
                   pattern="^.{2,10}\b(\£|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\_|\[|\]|\{|\}|\<|\>|\~|\`|\+|\=|\,|\.|\;|\:|\/|\?|\|)\b.{2,10}$" value="" tabindex="10"/>
        </p>

        <p>
            <label class='password' for="password_two">Confirm:</label>
            <input class='password-no-match' type="password" name="password_two" id="password_two" class="input" autocorrect=”off” autocapitalize=”off” autocomplete=”off” required="required"
                   pattern="^.{2,10}\b(\£|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\_|\[|\]|\{|\}|\<|\>|\~|\`|\+|\=|\,|\.|\;|\:|\/|\?|\|)\b.{2,10}$" value="" tabindex="20"
                   onkeyup="if(this.value == document.getElementById('password_one').value) { this.setAttribute('class', 'password-match'); } else { this.setAttribute('class', 'password-no-match'); }"/>
        </p>

        <p class="form_message">Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp;</p>

        <p class='submit'>
            <input class='submit' type="submit" name="submit" value="Reset Password" tabindex="100"/>
        </p>
    </div>
</form>

<?php
Page::footer();
?>