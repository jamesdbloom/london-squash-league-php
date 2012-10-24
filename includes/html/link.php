<?php
class Link
{
    public $url;

    public $text;

    public $class;

    public $query_string;

    const hide_on_very_small_screen = 'hide_on_very_small_screen';
    const hide_on_small_screen = 'hide_on_small_screen';
    const hide_on_medium_screen = 'hide_on_medium_screen';

    function __construct($url, $text, $class = '')
    {
        $this->url = $url;
        $this->text = $text;
        $this->class = $class;
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
    const Contact_Us = "Contact Us";
    const Enter_Score = "Enter Score";
    const Join_A_League = "Join A League";
    const Home = "Home";
    const League_Admin = "Leagues";
    const Login = "Login";
    const Logout = "Logout";
    const Lost_password = "Lost Password?";
    const Recreate_Tables = "Recreate Tables";
    const Register = "Register";
    const Report_Issue = "Report Issue";
    const Update_Password = "Update Password";
    const Update_User = "Update User";
    const Users_Sessions = "Users & Sessions";
    const View_League = "View League";

    const root = ROOT_OFFSET;

    const Account_Url = 'view/account/view.php';
    const Administration_Url = 'view/admin/administration.php';
    const Contact_Us_Url = "view/contact/contact_us.php";
    const Enter_Score_Url = 'view/score/view.php';
    const Landing_Url = "view/landing/index.php";
    const League_Admin_Url = "view/league_admin/view.php";
    const Login_Url = 'view/login/login.php';
    const Logout_Url = 'view/login/logout.php';
    const Register_Url = 'view/login/register.php';
    const Retrieve_Password_Url = 'view/login/retrieve_password.php';
    const Recreate_Tables_Url = 'recreate_schema_confirm.php';
    const Report_Issue_Url = 'view/contact/report_issue.php';
    const Update_Password_Url = 'view/login/update_password.php';
    const Update_User_Url = 'view/login/update_user.php';
    const User_Admin_Url = 'view/user_admin/view.php';
    const View_League_Url = 'view/league/view.php';

    public static function get_link($link_name, $fully_qualified = false, $text = '')
    {
        if (count(self::$links) <= 0) {
            self::$links[self::Account_Settings] = new Link(self::root . self::Account_Url, self::Account_Settings);
            self::$links[self::Administration] = new Link(self::root . self::Administration_Url, self::Administration, self::hide_on_small_screen);
            self::$links[self::Contact_Us] = new Link(self::root . self::Contact_Us_Url, self::Contact_Us, self::hide_on_very_small_screen);
            self::$links[self::Enter_Score] = new Link(self::root . self::Enter_Score_Url, self::Enter_Score, self::hide_on_small_screen);
            self::$links[self::Join_A_League] = new Link(self::root . self::Account_Url . '#divisions', self::Join_A_League);
            self::$links[self::Home] = new Link(Urls::get_root_url() . self::root, self::Home);
            self::$links[self::League_Admin] = new Link(self::root . self::League_Admin_Url, self::League_Admin);
            self::$links[self::Login] = new Link(self::root . self::Login_Url, self::Login);
            self::$links[self::Logout] = new Link(self::root . self::Logout_Url, self::Logout);
            self::$links[self::Lost_password] = new Link(self::root . self::Retrieve_Password_Url, self::Lost_password);
            self::$links[self::Recreate_Tables] = new Link(self::Recreate_Tables_Url, self::Recreate_Tables, self::hide_on_medium_screen);
            self::$links[self::Register] = new Link(self::root . self::Register_Url, self::Register);
            self::$links[self::Report_Issue] = new Link(self::root . self::Report_Issue_Url, self::Report_Issue, self::hide_on_very_small_screen);
            self::$links[self::Update_Password] = new Link(self::root . self::Update_Password_Url, self::Update_Password, self::hide_on_small_screen);
            self::$links[self::Update_User] = new Link(self::root . self::Update_User_Url, self::Update_User, self::hide_on_medium_screen);
            self::$links[self::Users_Sessions] = new Link(self::root . self::User_Admin_Url, self::Users_Sessions);
            self::$links[self::View_League] = new Link(self::root . self::View_League_Url, self::View_League);
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