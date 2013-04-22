<?php
class Urls
{
    public static function escape_and_sanitize_url($url)
    {
        $url = preg_replace('|[^a-z0-9-~+_.?#=&;,/:%!]|i', '', $url);
        $url = preg_replace('/\0+/', '', $url);
        $url = preg_replace('/(\\\\0)+/', '', $url);

        $strip = array('%0d', '%0a', '%0D', '%0A');
        $url = Strings::replace_all($strip, $url);
        return $url;
    }

    public static function is_validate_redirect_url($location)
    {
        $result = false;

        if (Strings::starts_with($location, '/')) {
            $result = true;
        } else {
            // browsers will redirect to a URL starting with '//' maintaining the protocol
            if (substr($location, 0, 2) == '//') {
                $raw_protocol = $_SERVER["SERVER_PROTOCOL"];
                // remove version number from 'HTTP/1.0'
                $protocol = ($end = strpos($raw_protocol, '/')) ? substr($raw_protocol, 0, $end) : $raw_protocol;
                $location = $protocol . ':' . $location;
            }

            // In php 5 parse_url may fail if the URL query part contains http://, bug #38143, which causes apache core dump
            $url_without_query_string = ($end = strpos($location, '?')) ? substr($location, 0, $end) : $location;

            $url_components = parse_url($url_without_query_string);

            // allow only http and https schemes and catches urls like https:host.com
            if (
                false !== $url_components &&
                isset($url_components['scheme']) && ('http' == $url_components['scheme'] || 'https' == $url_components['scheme']) &&
                isset($url_components['host'])
            ) {
                $result = strtolower($url_components['host']) == strtolower($_SERVER["SERVER_NAME"]);
            }
        }

        return $result;
    }

    public static function get_landing_page()
    {
        return self::get_root_url() . '/' . Link::Landing_Url;
    }

    public static function get_current_url()
    {
        return self::get_root_url() . self::get_current_path();
    }

    public static function get_current_url_non_beta()
    {
        return str_replace("beta", "www", self::get_current_url());
    }

    public static function get_current_path()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public static function get_root_url()
    {
        return "https://" . $_SERVER["SERVER_NAME"];
    }

    public static function is_beta()
    {
        return strstr($_SERVER["SERVER_NAME"], 'beta');
    }

    public static function webmaster_email()
    {
        return Urls::format_email('info');
    }

    public static function contact_us_email()
    {
        return Urls::format_email('contact_us');
    }

    public static function issue_report_email()
    {
        return Urls::format_email('issue_report');
    }

    private static function format_email($prefix)
    {
        if (strpos($_SERVER["SERVER_NAME"], 'www') === false) {
            return preg_replace('/beta./', $prefix . '@', $_SERVER["SERVER_NAME"]);
        } else {
            return preg_replace('/www./', $prefix . '@', $_SERVER["SERVER_NAME"]);
        }
    }

    const redirect_to = 'redirect_to';

    public static function redirect_url()
    {
        $current_path = Urls::get_current_path();
        if (strstr($current_path, "login")) {
            $current_path = Urls::get_landing_page();
        }
        return Form::escape_and_sanitize_field_value(Parameters::read_request_input(self::redirect_to, $current_path));
    }
}

?>