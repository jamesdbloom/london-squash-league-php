<?php
class Headers
{
    private static function get_status_header_desc($maybeint)
    {
        global $wp_header_to_desc;

        $code = abs(intval($maybeint));

        if (!isset($wp_header_to_desc)) {
            $wp_header_to_desc = array(
                100 => 'Continue',
                101 => 'Switching Protocols',
                102 => 'Processing',

                200 => 'OK',
                201 => 'Created',
                202 => 'Accepted',
                203 => 'Non-Authoritative Information',
                204 => 'No Content',
                205 => 'Reset Content',
                206 => 'Partial Content',
                207 => 'Multi-Status',
                226 => 'IM Used',

                300 => 'Multiple Choices',
                301 => 'Moved Permanently',
                302 => 'Found',
                303 => 'See Other',
                304 => 'Not Modified',
                305 => 'Use Proxy',
                306 => 'Reserved',
                307 => 'Temporary Redirect',

                400 => 'Bad Request',
                401 => 'Unauthorized',
                402 => 'Payment Required',
                403 => 'Forbidden',
                404 => 'Not Found',
                405 => 'Method Not Allowed',
                406 => 'Not Acceptable',
                407 => 'Proxy Authentication Required',
                408 => 'Request Timeout',
                409 => 'Conflict',
                410 => 'Gone',
                411 => 'Length Required',
                412 => 'Precondition Failed',
                413 => 'Request Entity Too Large',
                414 => 'Request-URI Too Long',
                415 => 'Unsupported Media Type',
                416 => 'Requested Range Not Satisfiable',
                417 => 'Expectation Failed',
                422 => 'Unprocessable Entity',
                423 => 'Locked',
                424 => 'Failed Dependency',
                426 => 'Upgrade Required',

                500 => 'Internal Server Error',
                501 => 'Not Implemented',
                502 => 'Bad Gateway',
                503 => 'Service Unavailable',
                504 => 'Gateway Timeout',
                505 => 'HTTP Version Not Supported',
                506 => 'Variant Also Negotiates',
                507 => 'Insufficient Storage',
                510 => 'Not Extended'
            );
        }

        if (isset($wp_header_to_desc[$code]))
            return $wp_header_to_desc[$code];
        else
            return '';
    }

    public static function set_status_header($code)
    {
        $text = self::get_status_header_desc($code);

        if (empty($text))
            return false;

        $protocol = $_SERVER["SERVER_PROTOCOL"];
        if ('HTTP/1.1' != $protocol && 'HTTP/1.0' != $protocol)
            $protocol = 'HTTP/1.0';
        $status_header = "$protocol $code $text";

        header($status_header, true, $code);
    }

    public static function set_nocache_headers()
    {
        $headers = array(
            'Expires' => 'Wed, 11 Jan 1984 05:00:00 GMT',
            'Last-Modified' => gmdate('D, d M Y H:i:s') . ' GMT',
            'Cache-Control' => 'no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
        );
        foreach ($headers as $name => $field_value)
            header("{$name}: {$field_value}");
    }

    public static function set_content_type_header()
    {
        header('Content-Type: text/html; charset=UTF-8');
    }

    public static function set_redirect_header($location)
    {
        if (Urls::is_validate_redirect_url($location)) {
            header('Location: ' . $location);
            // var_dump(debug_backtrace());
            exit;
        }
    }

    private static function get_referer()
    {
        $referer = $_SERVER['HTTP_REFERER'];
        if (empty($referer)) {
            $referer = Urls::get_root_url();
        }
        return $referer;
    }

    public static function redirect_to_referer()
    {
        self::set_redirect_header(self::get_referer());
    }

    public static function redirect_to_landing_page()
    {
        self::set_redirect_header(Urls::get_landing_page());
    }

    public static function redirect_to_root()
    {
        self::set_redirect_header(Urls::get_root_url());
    }

    public static function redirect_to_login($message = '')
    {
        self::set_redirect_header(
            Link::Login_Url .
                ($message ? '?' . LoginViewHelper::message . '=' . $message . '&' : '?') .
                Urls::redirect_to . '=' . Urls::get_current_path());
    }
}

?>