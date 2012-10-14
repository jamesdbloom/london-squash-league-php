<?php
class Footer
{
    static function outputFooter()
    {
        if ($GLOBALS['errors']->has_errors()) {
            page::basic_page('Error', "<a href='/secure'>Home</a>");
        } else {
            Headers::set_redirect_header(Link::Account_Url);
        }
    }
}

?>