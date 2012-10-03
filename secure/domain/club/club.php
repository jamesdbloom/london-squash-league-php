<?php
class Club
{
    public $id;

    public $name;

    public $address;

    function __construct($id, $name, $address)
    {
        register_shutdown_function(array(&$this, '__destruct'));

        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
    }

    function __destruct()
    {
        return true;
    }

    public function __toString()
    {
        return 'Id: ' . $this->id . ' Name: ' . $this->name . ' Address: ' . $this->address;
    }
}

?>