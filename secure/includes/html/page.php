<?php
class Page
{
    public static function header($title = '', $css_urls = array(), $message = '')
    {
        print "<!DOCTYPE>";
        print "<html xmlns='http://www.w3.org/1999/xhtml' lang='en'>";
        print "<head>";
        print "<title>PageSearchTerms::site_title &rsaquo; $title</title>";
        foreach ($css_urls as $css_url) {
            print "<link rel='stylesheet' type='text/css' href='$css_url'>";
        }
        print "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>";
        print "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        print "</head>";
        print "<body>";
        print "<h1><p><a href='https://" . $_SERVER["SERVER_NAME"] . "' title='" . PageSearchTerms::site_title . "'>" . PageSearchTerms::site_title . "</a></p></h1>";
        if (!empty($message)) {
            print "<p class='message'>$message</p>";
        }
        Error::print_errors();
    }

    public static function footer($links = array())
    {
        if (count($links) > 0) {
            print "<p>";
            foreach ($links as $key => $link) {
                print "<a href='" . $link[0] . "'>" . $link[1] . "</a>" . ($key+1 < count($links) ? "&nbsp;&#124;&nbsp;" : "");
            }
            print "</p>";
        }
        print "</body>";
        print "</html>";
    }

    public static function basic_page($title = '', $message = '')
    {
        self::header($title, array('/secure/view/global.css'), $message);
        self::footer();
    }
}
?>