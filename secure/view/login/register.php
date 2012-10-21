<?php
require_once('../../load.php');
load::load_file('view/login', 'login_view_helper.php');

$human_name = '';
$email = '';
$mobile = '';

if (Form::is_post()) {
    $human_name = Parameters::read_post_input('human_name');
    $email = Parameters::read_post_input('email');
    $mobile = Parameters::read_post_input('mobile');
    $mobile_privacy = Parameters::read_post_input('mobile_privacy');
    $league_id = Parameters::read_post_input('mobile_privacy');
    LoginViewHelper::validate_and_create_user($human_name, $email, $mobile, $mobile_privacy, $league_id);

    if (!$GLOBALS['errors']->has_errors()) {
        Headers::set_redirect_header(Link::Login_Url . "?" . LoginViewHelper::message . "=" . LoginViewHelper::registered);
        exit;
    }
}

Page::header(Link::Register);
?>

<form action='<?php echo Link::Register_Url; ?>' method='post'>
    <input type='hidden' name='redirect_to' value='<?php echo LoginViewHelper::redirect_url(); ?>'/>

    <p class='message'>Please enter your details and a temporary password will be e-mailed to you.</p>

    <div class='register_form'>

        <p>
            <label class='human_name' for='human_name'>Name:</label>
            <input id='human_name' class='show_validation' type='text' name='human_name' value='<?php echo Form::escape_and_sanitize_field_value($human_name); ?>' autocorrect=”off” autocapitalize=”off” autocomplete=”off” required='required' pattern='.{3,25}' tabindex='10'/>
        </p>

        <p>
            <label class='email' for='email'>Email:</label>
            <input id='email' class='show_validation' type='email' name='email' value='<?php echo Form::escape_and_sanitize_field_value($email); ?>' autocorrect=”off” autocapitalize=”off” autocomplete=”off” required='required'
                   pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?" tabindex='20'/>

        </p>

        <p>
            <label class='mobile' for='mobile'>Mobile:</label>
            <input id='mobile' class='show_validation' type='tel' name='mobile' value='<?php echo Form::escape_and_sanitize_field_value($mobile); ?>' autocorrect=”off” autocapitalize=”off” autocomplete=”off” pattern='\d{5,25}' tabindex='30'/>
        </p>

        <p>
            <label class='mobile_privacy' for='mobile_privacy'>Mobile Privacy:</label>
            <select id='mobile_privacy' name='mobile_privacy'>
                <option value='''>Please select...</option>
                <option value='secret''><?php echo User::get_mobile_privacy_text('secret'); ?></option>
                <option value='division''><?php echo User::get_mobile_privacy_text('division'); ?></option>
                <option value='league''><?php echo User::get_mobile_privacy_text('league'); ?></option>
                <option value='everyone''><?php echo User::get_mobile_privacy_text('everyone'); ?></option>
            </select>
        </p>

        <p>
            <label class='league' for='league_id'>League:</label>
            <?php
            load::load_file('view/league_admin', 'league_data.php');
            $leagueData = new LeagueData();
            print "<select name='league_id' required='required'>";
            print "<option value='''>Please select...</option>";
            foreach ($leagueData->league_list as $league) {
                print "<option value='' . $league->id . '''>" . $leagueData->print_league_name($league->id) . "</option>";
            }
            print '</select>';
            ?>
        </p>

        <p class='submit'>
            <input class='submit' type='submit' name='submit' value='Register' tabindex='100'/>
        </p>
    </div>
</form>

<?php
Page::footer();
?>