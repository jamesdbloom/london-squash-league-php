<?php
require_once('../../load.php');
load::load_file('view/login', 'login_view_helper.php');

LoginViewHelper::set_headers();

$human_name = '';
$email = '';
$mobile = '';

if (Form::is_post()) {
    $human_name = Parameters::read_post_input('human_name');
    $email = Parameters::read_post_input('email');
    $mobile = Parameters::read_post_input('mobile');
    LoginViewHelper::validate_and_create_user($human_name, $email, $mobile);

    if (!$GLOBALS['errors']->has_errors()) {
        Headers::set_redirect_header(LoginViewHelper::login_base_url . "login.php?" . LoginViewHelper::message . "=" . LoginViewHelper::registered);
        exit;
    }
}

Page::header('New User Registration', array('/secure/view/global.css'), '<p class="message register">' . 'Please enter your details and a temporary password will be e-mailed to you.' . '</p>');
?>

<form name="registerform" id="registerform" action="<?php echo LoginViewHelper::login_base_url . 'register.php'; ?>" method="post">
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

    <input type="hidden" name="redirect_to" value="<?php echo LoginViewHelper::redirect_url(); ?>"/>

    <p class="submit">
        <input type="submit" name="submit" class="button-primary" value="Register" tabindex="100"/>
    </p>
</form>

<?php
LoginViewHelper::login_footer();
?>