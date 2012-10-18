<?php
require_once('../../load.php');
load::load_file('view/login', 'login_view_helper.php');

class Page
{
    public static function header($title = '', $css_urls = array(), $title_suffix = '', $message = '', $links = array())
    {
        Headers::set_nocache_headers();
        Headers::set_content_type_header();
        Cookies::set_test_cookie();
        print "<!DOCTYPE>";
        print "<html xmlns='http://www.w3.org/1999/xhtml' lang='en'>";
        print "<head>";
        array_unshift($css_urls, '/secure/view/font_face/chaloops_regular_macroman/stylesheet.css');
        array_unshift($css_urls, '/secure/view/font_face/EarwigFactoryRegular/web fonts/earwigfactory_regular_macroman/stylesheet.css');
        array_unshift($css_urls, '/secure/view/global.css');
        print "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>";
        print "<meta name='format-detection' content='telephone=no'>";
        print "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        foreach ($css_urls as $css_url) {
            print "<link rel='stylesheet' type='text/css' href='$css_url'>";
        }
        print "<title>" . PageSearchTerms::site_title . " &rsaquo; $title</title>";
        print "</head>";
        print "<body>";
        print "<div id='container'>";
        if (!empty($title)) {
            print "<div id='header'>$title</div>";
        }
        $links = self::default_navigation($links);
        self::print_tab_navigation($links, $title);
        print "<div id='main_content'><div class='section'>";
        Error::print_errors();
        if (!empty($message)) {
            print "<p class='message'>$message</p>";
        }
    }

    public static function footer($links = array())
    {
        print "</div>"; // section
        print "</div>"; // main_content
        print "<div id='footer'><p>© 2012 James D Bloom</p></div>";
        print "</div>"; // container
        print "</body>";
        print "</html>";
    }

    private static function default_navigation($links = array())
    {
        array_unshift($links, Link::get_link(Link::Home));
        if (Session::has_active_session()) {
            $links[] = Link::get_link(Link::Account_Settings);
            $links[] = Link::get_link(Link::Logout);
        } else {
            $links[] = Link::get_link(Link::Login);
            $links[] = Link::get_link(Link::Register);
            $links[] = Link::get_link(Link::Lost_password);
        }
        return $links;
    }

    public static function print_tab_navigation($links, $active)
    {
        if (count($links) > 0) {
            print "<ul class='tabs'>";
            foreach ($links as $key => $link) {
                print "<li " . ($link->text == $active ? "class='active'" : "" ). ">$link</li>";
            }
            print "</ul>";
        }
    }

    public static function print_navigation($links, $class, $float_direction = 'right')
    {
        if (count($links) > 0) {
            print "<div class='$class'>&nbsp;";
            if ($float_direction == 'right') {
                foreach (array_reverse($links) as $key => $link) {
                    print "<div>" . $link . ($key > 0 ? " &#124; " : "&nbsp;&nbsp;") . "</div>";
                }
            } else {
                foreach ($links as $key => $link) {
                    print "<div>" . $link . ($key + 1 < count($links) ? " &#124; " : "&nbsp;&nbsp;") . "</div>";
                }
            }
            print "</div>";
        }
    }

    public static function basic_page($title = '', $message = '')
    {
        self::header($title, array(), $message);
        self::footer();
    }

    public static function not_authorised()
    {
        Headers::redirect_to_login(LoginViewHelper::not_authorised);
    }

    public static function not_logged_in()
    {
        Headers::redirect_to_login(LoginViewHelper::not_logged_in);
    }
}

?>