<?php
class Footer
{
    static function outputFooter()
    {
        if ($GLOBALS['errors']->has_errors()) {
            page::basic_page('Error', "<a href='". Link::root . Link::Landing_Url ."'>Home</a>");
        } else {
            Headers::set_redirect_header(Link::root . Link::League_Admin_Url);
        }
    }
}

?>