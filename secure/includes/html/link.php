<?php
class Link
{
    public $url;

    public $text;

    public $hide_on_small_screen;

    public $query_string;

    function __construct($url, $text, $hide_on_small_screen = false)
    {
        $this->url = $url;
        $this->text = $text;
        $this->hide_on_small_screen = $hide_on_small_screen;
    }

    public function add_query_string($query_string)
    {
        $this->query_string = $query_string;
        return $this;
    }

    public function __toString()
    {
        return "<a href='" . $this->url . (!empty($this->query_string) ? (strpos($this->url, '?') ? '&' : '?') . $this->query_string : '') . "' title='" . $this->text . "'>" . $this->text . "</a>";
    }

    private static $links = array();

    const Account_Settings = "Account";
    const Administration = "Administration";
    const Enter_Score = "Enter Score";
    const Join_A_League = "Join A League";
    const Home = "Home";
    const Leagues = "Leagues";
    const Login = "Login";
    const Logout = "Logout";
    const Lost_password = "Lost Password?";
    const Recreate_Tables = "Recreate Tables";
    const Register = "Register";
    const Update_Password = "Update Password";
    const Users_Sessions = "Users & Sessions";
    const View_League = "View League";

    const Account_Url = '/secure/view/account/view.php';
    const Landing_Url = "/secure/view/landing/index.php";
    const League_Admin_Url = "/secure/view/league_admin/view.php";
    const Login_Url = '/secure/view/login/login.php';
    const Register_Url = '/secure/view/login/register.php';
    const Update_Password_Url = '/secure/view/login/update_password.php';
    const Retrieve_Password_Url = '/secure/view/login/retrieve_password.php';
    const User_Admin_Url = '/secure/view/user_admin/view.php';
    const View_League_Url = '/secure/view/league/view.php';

    public static function get_link($link_name, $fully_qualified = false, $text = '')
    {
        if (count(self::$links) <= 0) {
            self::$links[self::Account_Settings] = new Link(self::Account_Url, self::Account_Settings);
            self::$links[self::Administration] = new Link('/secure/view/admin/administration.php', self::Administration, true);
            self::$links[self::Enter_Score] = new Link('/secure/view/score/view.php', self::Enter_Score, true);
            self::$links[self::Join_A_League] = new Link(self::Account_Url, self::Join_A_League);
            self::$links[self::Home] = new Link(Urls::get_root_url() . '/secure/', self::Home);
            self::$links[self::Leagues] = new Link(self::League_Admin_Url, self::Leagues);
            self::$links[self::Login] = new Link(self::Login_Url, self::Login);
            self::$links[self::Logout] = new Link('/secure/view/login/logout.php', self::Logout);
            self::$links[self::Lost_password] = new Link(self::Retrieve_Password_Url, self::Lost_password);
            self::$links[self::Register] = new Link(self::Register_Url, self::Register);
            self::$links[self::Recreate_Tables] = new Link('recreate_schema_confirm.php', self::Recreate_Tables, true);
            self::$links[self::Update_Password] = new Link(self::Update_Password_Url, self::Update_Password, true);
            self::$links[self::Users_Sessions] = new Link(self::User_Admin_Url, self::Users_Sessions);
            self::$links[self::View_League] = new Link(self::View_League_Url, self::View_League);
        }
        $link = self::$links[$link_name];
        if (empty($link)) {
            $link = new Link('/', 'LINK NOT FOUND');
        }
        if (!empty($text)) {
            $link->text = $text;
        }
        if ($fully_qualified) {
            $link->url = Urls::get_root_url() . $link->url;
        }
        return $link;
    }
}

?>