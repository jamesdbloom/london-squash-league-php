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
}

?>