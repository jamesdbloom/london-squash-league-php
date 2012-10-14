<?php
require_once('../../load.php');
load::load_file('view/login', 'login_view_helper.php');

LoginViewHelper::set_headers();

$email = '';

if (Form::is_post()) {
    $email = Parameters::read_post_input('email');
    $user = LoginViewHelper::validate_email_and_retrieve_user($email);

    if (!empty($user)) {
        $allow = Authentication::allow_password_reset($user->email);

        if ($allow && !$GLOBALS['errors']->has_errors()) {
            $key = UserDAO::get_activation_key($user->email);
            if (empty($key)) {
                // Generate something random for a key...
                $key = Authentication::generate_password(20);
                // Now insert the new md5 key into the db
                UserDAO::update_activation_key($user->email, $key);
            }

            $title = PageSearchTerms::site_title . ' Password Reset';
            $reset_url = Urls::get_root_url() . Link::Reset_Password_Url . "?key=" . rawurlencode($key) . "&email=" . rawurlencode($user->email);
            $message = '
                    <p>Someone requested that the password be reset for the account associated to this email address.</p>
                    <p>If this was a mistake, just ignore this email and nothing will happen.</p>
                    <p>To reset your password, visit the following address <a href="' . $reset_url . '">' . $reset_url . '</a></p>
                ';

            Email::send_email($user->email, $title, $message);
        }
    }

    if (!$GLOBALS['errors']->has_errors()) {
        Headers::set_redirect_header(Link::Login_Url . "?" . LoginViewHelper::message . "=" . LoginViewHelper::retrieve_password);
        exit;
    }
}

if (Parameters::read_request_input('error') == 'invalidkey') {
    $GLOBALS['errors']->add('invalidkey', 'Sorry, that key does not appear to be valid.', 'error');
}

Page::header(Link::Lost_password);
?>

<form action='<?php echo Link::Retrieve_Password_Url; ?>' method='post'>
    <input type='hidden' name='redirect_to' value='<?php echo LoginViewHelper::redirect_url(); ?>'/>

    <p class='message'>To receive a password reset link please enter your email.</p>

    <div class='retrieve_password_form'>
        <p>
            <label class='email' for="email">E-mail:</label>
            <input class='show_validation' type="email" name="email" class="input" value="<?php echo Urls::escape_and_sanitize_attribute_value($email); ?>" autocorrect=”off” autocapitalize=”off” autocomplete=”off” required="required"
                   pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?" tabindex="10"/>
        </p>

        <p class='submit'>
            <input class='submit' type="submit" name="submit" value="Get New Password" tabindex="100"/>
        </p>
    </div>
</form>

<?php
Page::footer();
?>