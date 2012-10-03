<?php
class InputValidation
{
    public static function clean_input($input)
    {
        // todo
        return stripslashes($input);
    }

    public static function is_valid_email_address($email)
    {
        // First, we check that there's one @ symbol,
        // and that the lengths are right.
        if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
            // Email invalid because wrong number of characters
            // in one section or wrong number of @ symbols.
            return false;
        }
        // Split it into sections to make life easier
        $email_array = explode("@", $email);
        $local_array = explode(".", $email_array[0]);
        for ($i = 0; $i < sizeof($local_array); $i++) {
            if
            (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
                $local_array[$i])
            ) {
                return false;
            }
        }
        // Check if domain is IP. If not,
        // it should be valid domain name
        if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
            $domain_array = explode(".", $email_array[1]);
            if (sizeof($domain_array) < 2) {
                return false; // Not enough parts to domain
            }
            for ($i = 0; $i < sizeof($domain_array); $i++) {
                if
                (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$",
                    $domain_array[$i])
                ) {
                    return false;
                }
            }
        }
        return true;
    }

    public static function is_valid_human_name($name)
    {
        $rexSafety = "/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i";
        if (preg_match($rexSafety, $name)) {
            return false;
        } else {
            return true;
        }
    }
}

?>