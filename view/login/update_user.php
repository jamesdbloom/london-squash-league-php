<?php
require_once('../../load.php');
load::load_file('view/login', 'login_view_helper.php');

$user = Session::get_user(true);

if (!empty($user)) {

    $human_name = $user->name;
    $email = $user->email;
    $mobile = $user->mobile;
    $mobile_privacy = $user->mobile_privacy;

    if (Form::is_post()) {
        $human_name = Parameters::read_post_input('human_name');
        $email = Parameters::read_post_input('email');
        $mobile = Parameters::read_post_input('mobile');
        $mobile_privacy = Parameters::read_post_input('mobile_privacy');

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
        } elseif ($email != $user->email && UserDAO::email_already_registered($email)) {
            $GLOBALS['errors']->add('email_exists', '<strong>ERROR</strong>: This email is already registered, please choose another one.');
        }

        if (!$GLOBALS['errors']->has_errors()) {
            $user = UserDAO::update($human_name, $email, $mobile, $mobile_privacy);
            if (empty($user)) {
                $GLOBALS['errors']->add('registration_failure', sprintf('<strong>ERROR</strong>: Couldn&#8217;t update user details... please contact <a href="mailto:%s">%s</a>', Urls::webmaster_email(), Urls::webmaster_email()));
            }
        }

        if (!$GLOBALS['errors']->has_errors()) {
            Headers::set_redirect_header(Link::root . Link::Account_Url);
            exit;
        }
    }

    $selected_string = "selected='selected'";

    Page::header(Link::Update_User);
    ?>

<form action='<?php echo Link::root . Link::Update_User_Url; ?>' method='post'>
    <div class='register_form'>

        <p>
            <label class='human_name' for='human_name'>Name:</label>
            <input id='human_name' class='show_validation' type='text' name='human_name' value='<?php echo Form::escape_and_sanitize_field_value($human_name); ?>' autocorrect=”off” autocapitalize=”off” autocomplete=”off” required='required' pattern='.{3,25}' tabindex='10'/>
        </p>

        <p>
            <label class='email' for='email'>Email:</label>
            <input id='email' class='show_validation' type='email' name='email' readonly="readonly" value='<?php echo Form::escape_and_sanitize_field_value($email); ?>' autocorrect=”off” autocapitalize=”off” autocomplete=”off” required='required'
                   pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?" tabindex='20'/>

        </p>

        <p>
            <label class='mobile' for='mobile'>Mobile:</label>
            <input id='mobile' class='show_validation' type='tel' name='mobile' value='<?php echo Form::escape_and_sanitize_field_value($mobile); ?>' autocorrect=”off” autocapitalize=”off” autocomplete=”off” pattern='\d{5,25}' tabindex='30'/>
        </p>

        <p>
            <label class='mobile_privacy' for='mobile_privacy'>Mobile Privacy:</label>
            <select id='mobile_privacy' name='mobile_privacy'><?php
                print "<option value=''>Please select...</option>";
                print "<option ".($mobile_privacy == User::secret ? $selected_string : '') ." value='" . User::secret . "'>" . User::get_mobile_privacy_text(User::secret) . "</option>";
                print "<option ".($mobile_privacy == User::division ? $selected_string : '') ." value='" . User::division . "'>" . User::get_mobile_privacy_text(User::division) . "</option>";
                print "<option ".($mobile_privacy == User::league ? $selected_string : '') ." value='" . User::league . "'>" . User::get_mobile_privacy_text(User::league) . "</option>";
                print "<option ".($mobile_privacy == User::everyone ? $selected_string : '') ." value='" . User::everyone . "'>" . User::get_mobile_privacy_text(User::everyone) . "</option>";
                ?></select>
        </p>

        <p class='submit'>
            <input class='submit primary' type='submit' name='submit' value='Update' tabindex='100'/>
        </p>
    </div>
</form>

<?php
    Page::footer();

}
?>