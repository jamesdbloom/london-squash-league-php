<?php
class Strings
{

    public static function replace_all($search, $subject)
    {
        $found = true;
        $subject = (string)$subject;
        while ($found) {
            $found = false;
            foreach ((array)$search as $val) {
                while (strpos($subject, $val) !== false) {
                    $found = true;
                    $subject = str_replace($val, '', $subject);
                }
            }
        }

        return $subject;
    }

    public static function starts_with($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    public static function ends_with($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
}

?>