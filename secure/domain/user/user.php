<?php
class User
{
    public $id;

    public $name;

    public $email;

    public $mobile;

    function __construct($id, $name, $email, $mobile)
    {
        register_shutdown_function(array(&$this, '__destruct'));

        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->mobile = $mobile;
    }

    function __destruct()
    {
        return true;
    }

    public function __toString()
    {
        return 'Id: ' . $this->id . ' Name: ' . $this->name . ' Email: ' . $this->email;
    }

    public static function send_new_user_notification(User $user, $password, Error $errors)
    {
        $title = PageSearchTerms::site_title . ' User Registration';
        $login_page_url = Urls::get_root_url() . login_url;
        $message = '
            <html>
            <head>
              <title>' . $title . '</title>
            </head>
            <body>
              <p>Someone registered an account associated to this email address.</p>
              <p>If this was a mistake, just ignore this email and nothing will happen.</p>
              <p>To login to you account using the details below on the login page: <a href="' . $login_page_url . '">' . $login_page_url . '</a></p>
              <p>Username: ' . $user->email . '</p>
              <p>Password: ' . $password . '</p>
            </body>
            </html>
            ';

        Email::send_email($user->email, $title, $message, $errors);
    }
}

?>