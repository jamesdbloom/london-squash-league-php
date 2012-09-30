<?php
class Email
{

    public static function send_email($to, $subject, $message, Error $errors)
    {
        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        $headers .= 'From: ' . Urls::get_webmaster_email() . "\r\n";
        $headers .= 'Bcc: ' . Urls::get_webmaster_email() . "\r\n";

        if(!mail($to, $subject, $message, $headers)) {
            $errors->add('email_failure', 'The e-mail could not be sent to address ' . $to);
            return false;
        } else {
            return true;
        }
    }
}

?>