<?php
class Club
{
    public $id;

    public $name;

    public $address;

    function __construct($id, $name, $address)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
    }

    public function __toString()
    {
        return 'Id: ' . $this->id . ' Name: ' . $this->name . ' Address: ' . $this->address;
    }
}

?>