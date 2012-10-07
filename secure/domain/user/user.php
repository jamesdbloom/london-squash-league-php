<?php
class User
{
    public $id;

    public $name;

    public $email;

    public $mobile;

    function __construct($id, $name, $email, $mobile)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->mobile = $mobile;
    }

    public function __toString()
    {
        return 'Id: ' . $this->id . ' Name: ' . $this->name . ' Email: ' . $this->email;
    }
}

?>