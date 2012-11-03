<?php

class Authentication
{
    public static function check_password_activation_key($key, $email)
    {
        $user = UserDAO::get_by_email_and_activation_key($email, $key);

        if (empty($user)) {
            $GLOBALS['errors']->add('invalidcombo', 'Error during password reset please contact ' . Urls::webmaster_email());
        }

        return $user;
    }

    public static function generate_password($length = 12, $use_special_character = false, $use_extra_special_characters = false)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        if ($use_special_character) {
            $chars .= "!@#$%^&*()";
        }
        if ($use_extra_special_characters) {
            $chars .= '-_ []{}<>~`+=,.;:/?|';
        }

        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= substr($chars, self::random(0, strlen($chars) - 1), 1);
        }

        // random_password filter was previously in random_password function which was deprecated
        return $password;
    }

    private static function random($min = 0, $max = 0)
    {
        global $rnd_value;

        // Reset $rnd_value after 14 uses
        // 32(md5) + 40(sha1) + 40(sha1) / 8 = 14 random numbers from $rnd_value
        if (strlen($rnd_value) < 8) {
            $seed = RANDOM_SEED;
            $rnd_value = md5(uniqid(microtime() . mt_rand(), true) . $seed);
            $rnd_value .= sha1($rnd_value);
            $rnd_value .= sha1($rnd_value . $seed);
        }

        // Take the first 8 digits for our value
        $value = substr($rnd_value, 0, 8);

        // Strip the first eight, leaving the remainder for the next call to random().
        $rnd_value = substr($rnd_value, 8);

        $value = abs(hexdec($value));

        // Reduce the value to be within the min - max range
        // 4294967295 = 0xffffffff = max random number
        if ($max != 0)
            $value = $min + (($max - $min + 1) * ($value / (4294967295 + 1)));

        return abs(intval($value));
    }

    public static function allow_password_reset($email)
    {
        $allow = true;
        if (!$allow) {
            $GLOBALS['errors']->add('no_password_reset', 'Password reset is not allowed for this user');
        }
        return $allow;
    }
}

?>