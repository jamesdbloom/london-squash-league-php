<?php
load::load_file('domain/session', 'sessionDAO.php');
class Session
{
    public $id;
    public $user_id;
    public $status;
    public $created_date;
    public $last_activity_date;

    const uuid_length = 35; // > 11 + 33
    const uuid_hash_length = 40;
    const SSO_ID_COOKIE_NAME = "secure_cookie";

    function __construct($id, $user_id, $status, $created_date, $last_activity_date, $errors)
    {
        register_shutdown_function(array(&$this, '__destruct'));

        $this->id = $id;
        $this->user_id = $user_id;
        $this->status = $status;
        $this->created_date = $created_date;
        $this->last_activity_date = $last_activity_date;
    }

    function __destruct()
    {
        return true;
    }

    public function __toString()
    {
        return 'Session for user: ' . $this->user_id . ' status: ' . $this->status . ' created: ' . date('Y-m-d H:i:s', $this->created_date) . ' last_activity: ' . date('Y-m-d H:i:s', $this->last_activity_date);
    }

    public static function generate_session_id($user_id, Error $errors)
    {
        $uuid = self::generate_uuid();

        $uuid_hash = self::generate_uuid_hash($user_id, $uuid);

        if (empty($uuid_hash)) {
            $errors->add('session', 'Error creating session');
        }

        return $uuid . $uuid_hash;
    }

    public static function generate_uuid()
    {
        $uuid = uniqid(mt_rand(), true);

        if (strlen($uuid) < self::uuid_length) {
            $uuid = str_pad($uuid, self::uuid_length, "AF", STR_PAD_RIGHT);
        } elseif (strlen($uuid) > self::uuid_length) {
            $uuid = substr($uuid, 0, self::uuid_length);
        }
        return $uuid;
    }

    public static function generate_uuid_hash($user_id, $uuid)
    {
        $seed = RANDOM_SEED + $user_id;
        $uuid_hash = md5($uuid . $seed);
        $uuid_hash .= sha1($uuid_hash);
        $uuid_hash .= sha1($uuid_hash . $seed);
        if (strlen($uuid_hash) < self::uuid_hash_length) {
            $uuid_hash = str_pad($uuid_hash, self::uuid_hash_length, "AF", STR_PAD_LEFT);
        } elseif (strlen($uuid_hash) > self::uuid_hash_length) {
            $uuid_hash = substr($uuid_hash, 0, self::uuid_hash_length);
        }
        return $uuid_hash;
    }

    public static function check_session_id($session_id, $user_id, Error $errors)
    {
        $uuid = substr($session_id, 0, self::uuid_length);

        $actual_uuid_hash = substr($session_id, -self::uuid_hash_length);
        $expected_uuid_hash = self::generate_uuid_hash($user_id, $uuid);

        if ($actual_uuid_hash == $expected_uuid_hash) {
            return true;
        } else {
            if (DEBUG) {
                $errors->add('sesssion', 'Invalid session id');
            }
            return false;
        }
    }

    public static function check_session_freshness($create_date, $status, Error $errors)
    {
        // todo
        // implement session expiry and session logout

        // $errors->add('expired', 'Your session has expired. Please log-in again.', 'message');

    }

    public static function create_session($email, $password, Error $errors)
    {
        $session = null;

        $secure_cookie = Cookies::get_cookie_value(self::SSO_ID_COOKIE_NAME);
        if (!empty($secure_cookie)) {
            $session = SessionDAO::get_by_id($secure_cookie, $errors);
        }

        if (!empty($session)) {
            if (self::validate_session($session, $errors)) {
                $errors->add('already_authenticated', 'You are already logged in.', 'message');
            }
        } else {
            $user = UserDAO::get_by_email_and_password($email, $password, $errors);
            if (!$errors->has_errors() && !empty($user)) {
                $session = SessionDAO::create(self::generate_session_id($user->id, $errors), $user->id, 'new ', $errors);
                if (!$errors->has_errors()) {
                    Cookies::set_cookie(self::SSO_ID_COOKIE_NAME, $session->id);
                }
            }
        }
        return $session;
    }

    public static function get_user(Error $errors)
    {
        $user = null;
        $secure_cookie = Cookies::get_cookie_value(self::SSO_ID_COOKIE_NAME);
        if (!empty($secure_cookie)) {
            $user = UserDAO::get_by_session_id($secure_cookie, $errors);
        }
        return $user;
    }

    public static function validate_session(Session $session, Error $errors)
    {
        self::check_session_id($session->id, $session->user_id, $errors);
        self::check_session_freshness($session->created_date, $session->status, $errors);

        return !$errors->has_errors();
    }

    public static function logout(Error $errors)
    {
        $secure_cookie = Cookies::get_cookie_value(self::SSO_ID_COOKIE_NAME);
        SessionDAO::delete_by_id($secure_cookie, $errors);
    }

    public static function print_hello_or_login_button()
    {
        $errors = new Error();
        $user = Session::get_user($errors);
        if ($errors->has_errors()) {
            Error::print_errors($errors);
        } else {
            if (!empty($user)) {
                print '<p>Hello ' . $user->name . '</p>';
            } else {
                print '<p><a href="/admin/view/login/login.php">Login</a></p>';
            }
        }
    }
}

?>