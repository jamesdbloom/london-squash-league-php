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

    const active = 'active';
    const inactive = 'inactive';
    const expired = 'expired';

    const inactive_period = ' -3 hour';
    const expired_period = ' -5 day';

    function __construct($id, $user_id, $status, $created_date, $last_activity_date)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->status = $status;
        $this->created_date = $created_date;
        $this->last_activity_date = $last_activity_date;
    }

    public function __toString()
    {
        return 'Session for user: ' . $this->user_id . ' status: ' . $this->status . ' created: ' . date('Y-m-d H:i:s', $this->created_date) . ' last_activity: ' . date('Y-m-d H:i:s', $this->last_activity_date);
    }

    public static function generate_session_id($user_id)
    {
        $uuid = self::generate_uuid();

        $uuid_hash = self::generate_hash($user_id, $uuid);

        if (empty($uuid_hash)) {
            $GLOBALS['errors']->add('session', 'Error creating session');
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

    public static function generate_hash($user_id, $uuid)
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

    public static function check_session_id($session_id, $user_id)
    {
        $uuid = substr($session_id, 0, self::uuid_length);

        $actual_uuid_hash = substr($session_id, -self::uuid_hash_length);
        $expected_uuid_hash = self::generate_hash($user_id, $uuid);

        if ($actual_uuid_hash == $expected_uuid_hash) {
            return true;
        } else {
            if (DEBUG) {
                $GLOBALS['errors']->add('sesssion', 'Invalid session id');
            }
            return false;
        }
    }

    public static function create_session($email, $password)
    {
        $session = null;
        $user = UserDAO::get_by_email_and_password($email, $password);
        if (empty($user)) {
            $GLOBALS['errors']->add('authentication_failure', 'Username and password combination incorrect.', 'warning');
        }
        if (!$GLOBALS['errors']->has_errors()) {
            $session = SessionDAO::create(self::generate_session_id($user->id), $user->id);
            if (!$GLOBALS['errors']->has_errors()) {
                Cookies::set_cookie(self::SSO_ID_COOKIE_NAME, $session->id);
            }
        }
        return $session;
    }

    public static function validate_session($session, $redirect = false)
    {
        $logged_in = !empty($session);

        if ($logged_in) {

            $valid = self::check_session_id($session->id, $session->user_id);

            if ($valid) {

                $session_fresh = $session->last_activity_date >= strtotime(self::inactive_period) && $session->created_date >= strtotime(self::expired_period);

                if ($session_fresh) {
                    SessionDAO::update_last_activity_date($session->id);
                    return true;
                } else {
                    SessionDAO::update_session_status();
                    if ($redirect) {
                        Page::session_expired();
                    }
                }
            }
        }
        if ($redirect) {
            Page::not_logged_in();
        }
        return false;
    }

    public static function get_session($redirect = false)
    {
        $session = null;

        $secure_cookie = Cookies::get_cookie_value(self::SSO_ID_COOKIE_NAME);
        if (!empty($secure_cookie)) {
            $session = SessionDAO::get_by_id($secure_cookie);
            if (self::validate_session($session, $redirect)) {
                return $session;
            } else {
                $session = null;
            }
        }

        return $session;
    }

    public static function has_active_session($redirect = false)
    {
        $session = self::get_session($redirect);
        return !empty($session);
    }

    public static function get_user($redirect = false)
    {
        $user = null;
        $session = self::get_session($redirect);
        if (!empty($session)) {
            $user = UserDAO::get_by_id($session->user_id);
        }
        return $user;
    }

    public static function is_administrator($redirect = false)
    {
        $user = self::get_user($redirect);
        return $user && $user->is_administrator();
    }

    public static function logout()
    {
        $secure_cookie = Cookies::get_cookie_value(self::SSO_ID_COOKIE_NAME);
        SessionDAO::delete_by_id($secure_cookie);
    }
}

?>