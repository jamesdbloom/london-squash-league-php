<?php
class Cookies
{
    const TEST_COOKIE_NAME = 'TEST_COOKIE';

    const DEFAULT_COOKIE_PATH = '/';

    const SESSION_COOKIE_EXPIRE = 0;

    const USE_SECURE = true;
    const HTTP_ONLY = true;

    public static function set_test_cookie()
    {
        self::set_cookie(Cookies::TEST_COOKIE_NAME, 'Cookie check');
    }

    public static function set_cookie($name, $value, $expire = null)
    {
        if (!isset($expire)) {
            $expire = Cookies::SESSION_COOKIE_EXPIRE;
        }
        setcookie(
            $name,
            $value,
            $expire,
            Cookies::DEFAULT_COOKIE_PATH,
            $_SERVER["SERVER_NAME"],
            Cookies::USE_SECURE,
            Cookies::HTTP_ONLY
        );
    }

    public static function remove_cookie($name)
    {
        self::set_cookie($name, '', time() - 31536000);
    }

    public static function get_test_cookie()
    {
        return InputValidation::clean_input($_COOKIE[Cookies::TEST_COOKIE_NAME]);
    }

    public static function get_cookie_value($cookie_name)
    {
        return InputValidation::clean_input($_COOKIE[$cookie_name]);
    }

}

?>