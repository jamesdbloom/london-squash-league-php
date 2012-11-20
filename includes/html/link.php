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

    const root = ROOT_OFFSET;

    #RewriteRule ^account$ view/account/view.php
    const Account_Url = 'account';
    const Account = "Account";
    const Join_A_League = "Join A League";
    #RewriteRule ^account/division_controller$ view/account/division_controller.php
    const Account_Division_Controller_Url = 'account/division_controller';
    const Account_Division_Controller = 'Account_Division_Controller';
    #RewriteRule ^account/create_controller$ view/account/create_controller.php
    const Account_Create_Controller_Url = 'account/create_controller';
    const Account_Create_Controller = 'Account Create Controller';

    const Print_League_Url = 'league?print=true';
    const Print_League = "Print League";

    #RewriteRule ^administration$ view/admin/administration.php
    const Administration_Url = 'administration';
    const Administration = "Administration";

    #RewriteRule ^contact_us$ view/contact/contact_us.php
    const Contact_Us_Url = 'contact_us';
    const Contact_Us = "Contact Us";
    #RewriteRule ^report_issue$ view/contact/report_issue.php
    const Report_Issue_Url = 'report_issue';
    const Report_Issue = "Report Issue";

    #RewriteRule ^$ /view/landing/index.php [L]
    const Landing_Url = '';
    const Landing = "Home";

    #RewriteRule ^league$ view/league/view.php
    const League_Url = 'league';
    const League = "View League";

    #RewriteRule ^league_admin$ view/league_admin/view.php
    const League_Admin_Url = 'league_admin';
    const League_Admin = "Leagues";
    #RewriteRule ^league_admin/recreate_schema_confirm$ view/league_admin/recreate_schema_confirm.php
    const League_Admin_Recreate_Tables_Url = 'league_admin/recreate_schema_confirm';
    const League_Admin_Recreate_Tables = 'Recreate League Tables';
    #RewriteRule ^league_admin/recreate_schema_controller$ view/league_admin/recreate_schema_controller.php
    const League_Admin_Recreate_Tables_Controller_Url = 'league_admin/recreate_schema_controller';
    const League_Admin_Recreate_Tables_Controller = 'League Admin Recreate Controller Tables';
    #RewriteRule ^league_admin/create_controller$ view/league_admin/create_controller.php
    const League_Admin_Create_Controller_Url = 'league_admin/create_controller';
    const League_Admin_Create_Controller = 'League Admin Create Controller';
    #RewriteRule ^league_admin/delete_controller$ view/league_admin/delete_controller.php
    const League_Admin_Delete_Controller_Url = 'league_admin/delete_controller';
    const League_Admin_Delete_Controller = 'League Admin Delete Controller';

    #RewriteRule ^login$ view/login/login.php
    const Login_Url = 'login';
    const Login = "Login";
    #RewriteRule ^logout$ view/login/logout.php
    const Logout_Url = 'logout';
    const Logout = "Logout";
    #RewriteRule ^register$ view/login/register.php
    const Register_Url = 'register';
    const Register = 'Register';
    #RewriteRule ^retrieve_password$ view/login/retrieve_password.php
    const Retrieve_Password_Url = 'retrieve_password';
    const Retrieve_Password = "Lost Password?";
    #RewriteRule ^update_password$ view/login/update_password.php
    const Update_Password_Url = 'update_password';
    const Update_Password = "Update Password";
    #RewriteRule ^update_user$ view/login/update_user.php
    const Update_User_Url = 'update_user';
    const Update_User = "Update User";

    #RewriteRule ^score$ view/score/view.php
    const Enter_Score_Url = 'score';
    const Enter_Score = "Enter Score";
    #RewriteRule ^score/score_controller$ view/score/score_controller.php
    const Enter_Score_Controller_Url = 'score/score_controller';
    const Enter_Score_Controller = 'Enter Score Controller';

    #RewriteRule ^user_admin$ view/user_admin/view.php
    const User_Admin_Url = 'user_admin';
    const Users_Admin = "Users & Sessions";
    #RewriteRule ^user_admin/recreate_schema_confirm$ view/user_admin/recreate_schema_confirm.php
    const User_Admin_Recreate_Tables_Url = 'user_admin/recreate_schema_confirm';
    const User_Admin_Recreate_Tables = 'Recreate User Tables';
    #RewriteRule ^user_admin/recreate_schema_controller$ view/user_admin/recreate_schema_controller.php
    const User_Admin_Recreate_Tables_Controller_Url = 'user_admin/recreate_schema_controller';
    const User_Admin_Recreate_Tables_Controller = 'User Admin Recreate Controller Tables';
    #RewriteRule ^user_admin/create_controller$ view/user_admin/create_controller.php
    const User_Admin_Create_Controller_Url = 'user_admin/create_controller';
    const User_Admin_Create_Controller = 'User Admin Create Controller';
    #RewriteRule ^user_admin/delete_controller$ view/user_admin/delete_controller.php
    const User_Admin_Delete_Controller_Url = 'user_admin/delete_controller';
    const User_Admin_Delete_Controller = 'User Admin Delete Controller';

    public static function get_link($link_name, $fully_qualified = false, $text = '')
    {
        if (count(self::$links) <= 0) {
            self::$links[self::Account] = new Link(self::root . self::Account_Url, self::Account);
            self::$links[self::Join_A_League] = new Link(self::root . self::Account_Url . '#divisions', self::Join_A_League);
            self::$links[self::Account_Division_Controller] = new Link(self::root . self::Account_Division_Controller_Url, self::Account_Division_Controller);
            self::$links[self::Account_Create_Controller] = new Link(self::root . self::Account_Create_Controller_Url, self::Account_Create_Controller);
            self::$links[self::Administration] = new Link(self::root . self::Administration_Url, self::Administration, self::hide_on_medium_screen);
            self::$links[self::Contact_Us] = new Link(self::root . self::Contact_Us_Url, self::Contact_Us, self::hide_on_small_screen);
            self::$links[self::Report_Issue] = new Link(self::root . self::Report_Issue_Url, self::Report_Issue, self::hide_on_medium_screen);
            self::$links[self::Landing] = new Link(self::root . self::Landing_Url, self::Landing);
            self::$links[self::League] = new Link(self::root . self::League_Url, self::League);
            self::$links[self::League_Admin] = new Link(self::root . self::League_Admin_Url, self::League_Admin);
            self::$links[self::League_Admin_Recreate_Tables] = new Link(self::root . self::League_Admin_Recreate_Tables_Url, self::League_Admin_Recreate_Tables, self::hide_on_medium_screen);
            self::$links[self::League_Admin_Recreate_Tables_Controller] = new Link(self::root . self::League_Admin_Recreate_Tables_Controller_Url, self::League_Admin_Recreate_Tables_Controller);
            self::$links[self::League_Admin_Create_Controller] = new Link(self::root . self::League_Admin_Create_Controller_Url, self::League_Admin_Create_Controller);
            self::$links[self::League_Admin_Delete_Controller] = new Link(self::root . self::League_Admin_Delete_Controller_Url, self::League_Admin_Delete_Controller);
            self::$links[self::Login] = new Link(self::root . self::Login_Url, self::Login);
            self::$links[self::Logout] = new Link(self::root . self::Logout_Url, self::Logout);
            self::$links[self::Register] = new Link(self::root . self::Register_Url, self::Register);
            self::$links[self::Retrieve_Password] = new Link(self::root . self::Retrieve_Password_Url, self::Retrieve_Password);
            self::$links[self::Print_League_Url] = new Link(self::root . self::Print_League_Url, self::Print_League, self::hide_on_small_screen);
            self::$links[self::Update_Password] = new Link(self::root . self::Update_Password_Url, self::Update_Password, self::hide_on_small_screen);
            self::$links[self::Update_User] = new Link(self::root . self::Update_User_Url, self::Update_User, self::hide_on_medium_screen);
            self::$links[self::Enter_Score] = new Link(self::root . self::Enter_Score_Url, self::Enter_Score, self::hide_on_small_screen);
            self::$links[self::Enter_Score_Controller] = new Link(self::root . self::Enter_Score_Controller_Url, self::Enter_Score_Controller);
            self::$links[self::Users_Admin] = new Link(self::root . self::User_Admin_Url, self::Users_Admin);
            self::$links[self::User_Admin_Recreate_Tables] = new Link(self::root . self::User_Admin_Recreate_Tables_Url, self::User_Admin_Recreate_Tables, self::hide_on_medium_screen);
            self::$links[self::User_Admin_Recreate_Tables_Controller] = new Link(self::root . self::User_Admin_Recreate_Tables_Controller_Url, self::User_Admin_Recreate_Tables_Controller);
            self::$links[self::User_Admin_Create_Controller] = new Link(self::root . self::User_Admin_Create_Controller_Url, self::User_Admin_Create_Controller);
            self::$links[self::User_Admin_Delete_Controller] = new Link(self::root . self::User_Admin_Delete_Controller_Url, self::User_Admin_Delete_Controller);
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