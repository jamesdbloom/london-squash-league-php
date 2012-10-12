<?php
require_once('../../load.php');
load::load_file('view/login', 'login_view_helper.php');

class Page
{
    public static function header($title = '', $css_urls = array(), $message = '', $links = array())
    {
        print "<!DOCTYPE>";
        print "<html xmlns='http://www.w3.org/1999/xhtml' lang='en'>";
        print "<head>";
        print "<title>" . PageSearchTerms::site_title . " &rsaquo; $title</title>";
        array_unshift($css_urls, '/secure/view/global.css');
        // array_unshift($css_urls, '/secure/view/reset.css');
        foreach ($css_urls as $css_url) {
            print "<link rel='stylesheet' type='text/css' href='$css_url'>";
        }
        print "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>";
        print "<meta name='format-detection' content='telephone=no'>";
        print "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        print "</head>";
        print "<body>";
        $links = self::default_navigation($links);
        self::print_navigation($links, 'header-navigation', 'right');
        if (!empty($title)) {
            print "<h2>$title</h2>";
        }
        if (!empty($message)) {
            print "<p class='message'>$message</p>";
        }
        Error::print_errors();
    }

    public static function footer($links = array())
    {
        $links = self::default_navigation($links);
        self::print_navigation($links, 'footer-navigation', 'left');
        print "</body>";
        print "</html>";
    }

    private static function default_navigation($links)
    {
        array_unshift($links, new Link(Urls::get_root_url() . '/secure/', 'Home'));
        if (Session::has_active_session()) {
            if (Session::is_administrator()) {
                $links[] = new Link('/secure/view/league/view.php', 'Leagues');
                $links[] = new Link('/secure/view/authentication/view.php', 'Users & Sessions');
            }
            $links[] = new Link('/secure/view/account/view.php', 'Account Settings');
            $links[] = new Link('/secure/view/login/retrieve_password.php', 'Update Password');
            $links[] = new Link('/secure/view/login/logout.php', 'Logout');
        } else {
            $links[] = new Link('/secure/view/login/login.php', 'Login');
            $links[] = new Link(LoginViewHelper::login_base_url . 'register.php', 'Register');
            $links[] = new Link(LoginViewHelper::login_base_url . 'retrieve_password.php', 'Lost password?');
        }
        return $links;
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