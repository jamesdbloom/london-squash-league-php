<?php
require_once('../../load.php');

if (Form::is_post()) {

    $title = PageSearchTerms::site_title . ' ' . Link::Contact_Us;
    $message = '
            <p>A message has been submitted as follows:</p>
            <p>Email: '. Parameters::read_request_input('email') .'</p>
            <p>Message: '. Parameters::read_request_input('contact_message') .'</p>
            <p>User Agent: '. Parameters::read_request_input('user_agent') .'</p>
            <p>Browser Language: '. Parameters::read_request_input('browser_language') .'</p>
            <p>Remote Address: '. Parameters::read_request_input('remote_address') .'</p>
        ';

    Email::send_email(Urls::contact_us_email(), $title, $message, Urls::contact_us_email());

    Page::header(Link::Contact_Us);
    print "<p class='message'>Your message has been sent someone may contact you for more details</p>";
    Page::footer();
    exit;

} else {

    $user = Session::get_user(true);

    if (!empty($user)) {

        Page::header(Link::Contact_Us);
        ?>

    <form action='<?php echo Link::root . Link::Contact_Us_Url; ?>' method='post'>

        <p class='message'>To report an issue, defect or bug on the site please use the <?php echo Link::get_link(Link::Report_Issue) ?> page, to contact us about anything else please enter a message below and we will get back to you as soon as we can</p>

        <div class='send_message_form'>

            <input id='user_agent' type='hidden' name='user_agent' readonly='readonly' value='<?php echo Form::escape_and_sanitize_field_value(Parameters::read_header('HTTP_USER_AGENT')); ?>'/>
            <input id='browser_language' type='hidden' name='browser_language' readonly='readonly' value='<?php echo Form::escape_and_sanitize_field_value(Parameters::read_header('HTTP_ACCEPT_LANGUAGE')); ?>'/>
            <input id='remote_address' type='hidden' name='remote_address' readonly='readonly' value='<?php echo Form::escape_and_sanitize_field_value(Parameters::read_header('REMOTE_ADDR')); ?>'/>

            <p>
                <label class='email' for='email'>Your Email:</label>
                <input id='email' type='email' name='email' readonly='readonly' value='<?php echo Form::escape_and_sanitize_field_value($user->email); ?>'/>

            </p>

            <p>
                <label class='contact_message' for='contact_message'>Message:</label>
                <textarea id='contact_message' name='contact_message' class='show_validation' cols='58' rows='15' autocorrect=”off” autocapitalize=”off” autocomplete=”off” required="required" tabindex="10"></textarea>
            </p>

            <p class='submit'>
                <input class='submit' type='submit' name='submit' value='Send Message' tabindex='100'/>
            </p>
        </div>
    </form>

    <?php

        Page::footer();

    }

}

?>