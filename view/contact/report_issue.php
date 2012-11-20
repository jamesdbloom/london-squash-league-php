<?php
require_once('../../load.php');

if (Form::is_post()) {

    $title = PageSearchTerms::site_title . ' ' . Link::Report_Issue;
    $message = '
            <p>An issue was raised as follows:</p>
            <p>Email: '. Parameters::read_request_input('email') .'</p>
            <p>User Agent: '. Parameters::read_request_input('user_agent') .'</p>
            <p>Browser Language: '. Parameters::read_request_input('browser_language') .'</p>
            <p>Remote Address: '. Parameters::read_request_input('remote_address') .'</p>
            <p>Bug Description: '. Parameters::read_request_input('bug_description') .'</p>
        ';

    Email::send_email(Urls::issue_report_email(), $title, $message, Parameters::read_request_input('email'));

    Page::header(Link::Report_Issue);
    print "<p class='message'>Your issue report has been submitted someone may contact you for more details</p>";
    Page::footer();
    exit;

} else {

    $user = Session::get_user(true);

    if (!empty($user)) {

        Page::header(Link::Report_Issue);
        ?>

    <form action='<?php echo Link::root . Link::Report_Issue_Url; ?>' method='post'>

        <p class='message'>Please enter details of the issue and an email will be sent to the site administrator</p>

        <div class='report_issue_form'>

            <p>
                <label class='email' for='email'>Your Email:</label>
                <input id='email' type='email' name='email' readonly='readonly' value='<?php echo Form::escape_and_sanitize_field_value($user->email); ?>'/>

            </p>

            <p>
                <label class='user_agent' for='user_agent'>Your Browser:</label>
                <input id='user_agent' type='text' name='user_agent' readonly='readonly' value='<?php echo Form::escape_and_sanitize_field_value(Parameters::read_header('HTTP_USER_AGENT')); ?>'/>
            </p>

            <p>
                <label class='browser_language' for='browser_language'>Your Language:</label>
                <input id='browser_language' type='text' name='browser_language' readonly='readonly' value='<?php echo Form::escape_and_sanitize_field_value(Parameters::read_header('HTTP_ACCEPT_LANGUAGE')); ?>'/>
            </p>

            <p>
                <label class='remote_address' for='remote_address'>Your Address:</label>
                <input id='remote_address' type='text' name='remote_address' readonly='readonly' value='<?php echo Form::escape_and_sanitize_field_value(Parameters::read_header('REMOTE_ADDR')); ?>'/>
            </p>

            <p>
                <label class='bug_description' for='bug_description'>Bug Description:</label>
                <textarea id='bug_description' name='bug_description' class='show_validation' cols='58' rows='15' autocorrect=”off” autocapitalize=”off” autocomplete=”off” required="required" tabindex="10"></textarea>
            </p>

            <p class='submit'>
                <input class='submit primary' type='submit' name='submit' value='Report' tabindex='100'/>
            </p>
        </div>
    </form>

    <?php

        Page::footer();

    }

}

?>