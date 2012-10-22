<?php
class User
{
    public $id;

    public $name;

    public $email;

    public $mobile;

    public $mobile_privacy;

    public $salt;

    public $type;

    public static $mobile_privacy_text = array();

    const player = 'player';
    const administrator = 'administrator';
    const secret = 'secret';
    const division = 'division';
    const league = 'league';
    const everyone = 'everyone';

    function __construct($id, $name, $email, $mobile, $mobile_privacy, $salt, $type = User::player)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->mobile = $mobile;
        $this->mobile_privacy = $mobile_privacy;
        $this->salt = $salt;
        $this->type = $type;
    }

    public function __toString()
    {
        return 'Id: ' . $this->id . ' Name: ' . $this->name . ' Email: ' . $this->email . ' Type: ' . $this->type;
    }

    public function is_administrator()
    {
        return ($this->type == User::administrator || $this->email == 'jamesdbloom@gmail.com' || $this->email == 'andrea.caldera@gmail.com');
    }

    public static function get_mobile_privacy_text($mobile_privacy)
    {
        if (count(self::$mobile_privacy_text) <= 0) {
            self::$mobile_privacy_text['secret'] = 'Keep secret';
            self::$mobile_privacy_text['division'] = 'Players in division';
            self::$mobile_privacy_text['league'] = 'Players in league';
            self::$mobile_privacy_text['everyone'] = 'Show everyone';
        }
        return self::$mobile_privacy_text[$mobile_privacy];
    }

    public static function generate_salt()
    {
        return Session::generate_uuid();
    }

    public static function hash_password($password, $salt)
    {
        return Session::generate_hash($password, $salt);
    }
}

?>