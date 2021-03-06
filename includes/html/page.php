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
        array_unshift($css_urls, Link::root . (Urls::is_beta() ? 'view/global.css' : 'view/global_2013_01_15_19_21.css'));
        print "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>";
        print "<meta name='format-detection' content='telephone=no'>";
        print "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        foreach ($css_urls as $css_url) {
            print "<link rel='stylesheet' type='text/css' media='all' href='$css_url'>";
        }
        print "<link rel='stylesheet' type='text/css' media='print' href='view/print.css' />";
        print "<link rel='canonical' href='" . Urls::get_current_url_non_beta() . "'/>";
        print "<title>" . PageSearchTerms::site_title . " &rsaquo; $title</title>";
        print "</head>";
        print "<body>";
        print "<div id='container'>"; // container
        if (!empty($title)) {
            print "<div id='header'>$title" . (!empty($title_suffix) ? "<div id='header_suffix'> - $title_suffix</div>" : "") . "</div>";
        }
        $links = self::default_navigation($links);
        self::print_tab_navigation($links, $title);
        print "<div id='main_content'>"; // main_content
        print "<div class='section'>"; // section
        Error::print_errors();
        if (!empty($message)) {
            print "<p class='message'>$message</p>";
        }
    }

    public static function footer($links = array())
    {
        print "</div>"; // section
        print "</div>"; // main_content
        print "<div id='footer'><p><a href='http://blog.jamesdbloom.com/'>© 2012 James D Bloom</a></p></div>";
        print "<div style='display: none'>";
        print "    <a href='http://blog.jamesdbloom.com/JVMInternals.html'><p>JVM Internals</p></a>";
        print "    <a href='http://blog.jamesdbloom.com/TestingWebPagesInProcess.html'><p>Testing Web Pages In Process</p></a>";
        print "    <a href='http://blog.jamesdbloom.com/JSAndCSSMinificationWithWRO4J.html'><p>JS and CSS Minification With WRO4J</p></a>";
        print "    <a href='http://blog.jamesdbloom.com/UsingPropertySourceAndEnvironment.html'><p>Using PropertySource & Environment</p></a>";
        print "    <a href='http://blog.jamesdbloom.com/ReducingAndMinifyingRequests.html'><p>Reducing & Minifying Requests</p></a>";
        print "    <a href='http://blog.jamesdbloom.com/HighPerformanceMobileWebsites.html'><p>High Performance Mobile Websites</p></a>";
        print "    <a href='http://blog.jamesdbloom.com/MobileStrategy.html'><p>Mobile Strategy</p></a>";
        print "    <a href='http://blog.jamesdbloom.com/AvoidJavaScriptForMobileWeb.html'><p>Avoid JavaScript for Mobile Web</p></a>";
        print "    <a href='http://blog.jamesdbloom.com/WhyDoesWebPerformanceMatter.html'><p>Why Does Web Performance Matter?</p></a>";
        print "    <a href='http://blog.jamesdbloom.com/MobileWebBestPractices.html'><p>Mobile Web Best Practices</p></a>";
        print "    <a href='http://blog.jamesdbloom.com/HowToFloatCorrectly.html'><p>How To Float Correctly</p></a>";
        print "    <a href='http://blog.jamesdbloom.com/WhyUseApplicationCache.html'><p>Why use Application Cache?</p></a>";
        print "    <a href='http://blog.jamesdbloom.com/HowToUseApplicationCache.html'><p>How to use Application Cache?</p></a>";
        print "    <a href='http://blog.jamesdbloom.com/TipsForUsingApplicationCache.html'><p>Tips using Application Cache?</p></a>";
        print "    <a href='http://blog.jamesdbloom.com/ProblemsWithApplicationCache.html'><p>Problems with Application Cache?</p></a>";
        print "    <a href='http://blog.jamesdbloom.com/JavaScriptAndApplicationCache.html'><p>JavaScript and Application Cache?</p></a>";
        print "</div>";
        print "</div>"; // container
        ?>
    <!-- google analytics start -->
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-32687194-3']);
        _gaq.push(['_trackPageview']);
        (function () {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
    </script>
    <!-- google analytics end -->
    <?php
        print "</body>";
        print "</html>";
    }

    private static function default_navigation($links = array())
    {
        if (Session::has_active_session()) {
            array_unshift($links, Link::get_link(Link::Account));
            if (Session::is_administrator()) {
                array_unshift($links, Link::get_link(Link::Administration));
            }
            if(Session::is_league_manager()){
                array_unshift($links, Link::get_link(Link::Print_League));
            }
            array_unshift($links, Link::get_link(Link::Ranking));
            array_unshift($links, Link::get_link(Link::League));
            $links[] = Link::get_link(Link::Report_Issue);
            $links[] = Link::get_link(Link::Contact_Us);
            $links[] = Link::get_link(Link::Logout);
        } else {
            $links[] = Link::get_link(Link::Login);
            $links[] = Link::get_link(Link::Register);
            $links[] = Link::get_link(Link::Retrieve_Password);
        }
        array_unshift($links, Link::get_link(Link::Landing));
        return $links;
    }

    public static function print_tab_navigation($links, $active)
    {
        if (count($links) > 0) {
            print "<ul class='tabs'>";
            foreach ($links as $link) {
                print "<li class='" . $link->class . " " . ($link->text == $active ? "active" : "") . "''>$link</li>";
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
        exit;
    }

    public static function not_logged_in()
    {
        Headers::redirect_to_login(LoginViewHelper::not_logged_in);
        exit;
    }

    public static function session_expired()
    {
        Headers::redirect_to_login(LoginViewHelper::session_expired);
        exit;
    }
}

?>
