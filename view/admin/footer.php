<?php
class Footer
{
    static function outputAccountFooter($query_string = '')
    {
        if ($GLOBALS['errors']->has_errors()) {
            page::basic_page('Error', "<a href='". Link::root . Link::Landing_Url ."'>Home</a>");
        } else {
            Headers::set_redirect_header(Link::root . Link::Account_Url . $query_string);
        }
    }

    static function outputUserAdminFooter()
    {
        if ($GLOBALS['errors']->has_errors()) {
            page::basic_page('Error', "<a href='". Link::root . Link::Landing_Url ."'>Home</a>");
        } else {
            Headers::set_redirect_header(Link::root . Link::User_Admin_Url);
        }
    }

    static function outputLeagueAdminFooter()
    {
        if ($GLOBALS['errors']->has_errors()) {
            page::basic_page('Error', "<a href='". Link::root . Link::Landing_Url ."'>Home</a>");
        } else {
            Headers::set_redirect_header(Link::root . Link::League_Admin_Url);
        }
    }
}

?>