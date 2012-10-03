<?php
class Round
{
    public $id;

    public $division_id;

    public $name;

    function __construct($id, $division_id, $name)
    {
        register_shutdown_function(array(&$this, '__destruct'));

        $this->id = $id;
        $this->division_id = $division_id;
        $this->name = $name;
    }

    function __destruct()
    {
        return true;
    }

    public function __toString()
    {
        return 'Id: ' . $this->id . ' Division Id: ' . $this->division_id . ' Name: ' . $this->name;
    }
}

?>