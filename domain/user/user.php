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
    const league_manager = 'league_manager';
    const secret = 'secret';
    const opponent = 'opponent';

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
        return ($this->type == User::administrator || $this->email == 'jamesdbloom@gmail.com' || $this->email == 'james.bloom@betfair.com' || $this->email == 'andrea.caldera@gmail.com');
    }

    public function is_league_manager()
    {
        return ($this->type == User::league_manager || $this->email == 'jamesdbloom@gmail.com' || $this->email == 'james.bloom@betfair.com' || $this->email == 'andrea.caldera@gmail.com' || $this->email == 'tracey.evans@gll.org' || $this->email == 'andy@jobs4tennis.com');
    }

    public static function get_mobile_privacy_text($mobile_privacy)
    {
        if (count(self::$mobile_privacy_text) <= 0) {
            self::$mobile_privacy_text['secret'] = 'Keep secret';
            self::$mobile_privacy_text['opponent'] = 'Show opponent';
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