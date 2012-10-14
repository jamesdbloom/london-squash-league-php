<?php
class User
{
    public $id;

    public $name;

    public $email;

    public $mobile;

    public $type;

    const player = 'player';
    const administrator = 'administrator';

    function __construct($id, $name, $email, $mobile, $type = User::player)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->mobile = $mobile;
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
}

?>