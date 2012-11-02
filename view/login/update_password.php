<?php
require_once('../../load.php');
load::load_file('view/login', 'login_view_helper.php');

$key = rawurldecode(Parameters::read_get_input('key'));
if (!empty($key)) {
    $email = rawurldecode(Parameters::read_get_input('email'));
    $user = Authentication::check_password_activation_key($key, $email);
    if (empty($user)) {
        Headers::set_redirect_header(Link::root . Link::Retrieve_Password_Url . '?error=invalidkey');
    }
} else {
    $user = Session::get_user();
    if (!empty($user)) {
        $email = $user->email;
    }
}

if (Form::is_post()) {
    $password_one = Parameters::read_post_input('password_one');
    $password_two = Parameters::read_post_input('password_two');
    $existing_password = Parameters::read_post_input('existing_password');
    if (!empty($email)) {
        UserDAO::update_activation_key($email, '');
    }
    if (!empty($password_one) && $password_one != $password_two) {
        $GLOBALS['errors']->add('password_reset_mismatch', 'The passwords do not match.');
    } else {
        $user = UserDAO::get_by_email_and_password($email, $existing_password);
        if(empty($user)) {
            $GLOBALS['errors']->add('existing_password_incorrect', 'Your existing password is incorrect');
        } else {
            UserDAO::update_password($user->email, $password_one);
        }

        $message = 'Password Lost and Changed for user: ' . $email . '\r\n';
        Email::send_email(Urls::webmaster_email(), PageSearchTerms::site_title . ' Password Lost/Changed', $message);
    }

    if (!$GLOBALS['errors']->has_errors()) {
        Page::header(Link::Update_Password, array(), '', "Your password has been reset " . (!Session::has_active_session() ? Link::get_link(Link::Login) : ''));
        Page::footer();
        exit;
    }
}

Page::header(Link::Update_Password, array(), '', "Enter your new password below.");

if (!empty($key) && !empty($email)) {
    $query = '?key=' . rawurlencode($key) . '&email=' . rawurlencode($email);
} else {
    $query = '';
}
?>

<form action='<?php echo Link::root . Link::Update_Password_Url . $query; ?>' method='post'>
    <input type="hidden" name="email" value="<?php echo Form::escape_and_sanitize_field_value(Parameters::read_post_input('email')); ?>"/>

    <div class="reset_password_form">
        <p>
            <label class='password' for="existing_password">Existing Password:</label>
            <input id="existing_password" type="password" name="existing_password" autocorrect=”off” autocapitalize=”off” autocomplete=”off” required="required"
                   value="" tabindex="10"/>
        </p>

        <p>
            <label class='password' for="password_one">New Password:</label>
            <input id="password_one" class='show_validation' type="password" name="password_one" autocorrect=”off” autocapitalize=”off” autocomplete=”off” required="required"
                   pattern="^.*(?=.{6,})(?=.*\d)(?=.*(\£|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\_|\[|\]|\{|\}|\<|\>|\~|\`|\+|\=|\,|\.|\;|\:|\/|\?|\|))(?=.*[a-zA-Z]).*$" value="" tabindex="20"/>
        </p>

        <p>
            <label class='password' for="password_two">Confirm:</label>
            <input id="password_two" class='password-no-match' type="password" name="password_two" autocorrect=”off” autocapitalize=”off” autocomplete=”off” required="required"
                   pattern="^.*(?=.{6,})(?=.*\d)(?=.*(\£|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\_|\[|\]|\{|\}|\<|\>|\~|\`|\+|\=|\,|\.|\;|\:|\/|\?|\|))(?=.*[a-zA-Z]).*$" value="" tabindex="30"
                   onkeyup="if(this.value == document.getElementById('password_one').value) { this.setAttribute('class', 'password-match'); } else { this.setAttribute('class', 'password-no-match'); }"/>
        </p>

        <p class="form_message">Hint: The password should be at least seven characters long, include at least one symbol (i.e. ! " ? $ % ^ &) and at least one digit</p>

        <p class='submit'>
            <input class='submit primary' type="submit" name="submit" value="Reset Password" tabindex="100"/>
        </p>
    </div>
</form>

<?php
Page::footer();
?>
