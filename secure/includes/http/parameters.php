<?php
class Parameters
{
    public static function read_post_input($name, $default_value = '')
    {
        return self::default_if_empty(InputValidation::clean_input($_POST[$name]), $default_value);
    }

    public static function read_get_input($name, $default_value = '')
    {
        return self::default_if_empty(InputValidation::clean_input($_GET[$name]), $default_value);
    }

    public static function read_request_input($name, $default_value = '')
    {
        return self::default_if_empty(InputValidation::clean_input($_REQUEST[$name]), $default_value);
    }

    private static function default_if_empty($input_value, $default_value)
    {
        if (!empty($input_value)) {
            return $input_value;
        } else {
            return $default_value;
        }
    }
}

?>