<?php
class Division
{
    public $id;

    public $league_id;

    public $name;

    function __construct($id, $league_id, $name)
    {
        register_shutdown_function(array(&$this, '__destruct'));

        $this->id = $id;
        $this->league_id = $league_id;
        $this->name = $name;
    }

    function __destruct()
    {
        return true;
    }

    public function __toString()
    {
        return 'Id: ' . $this->id . ' League Id: ' . $this->league_id . ' Name: ' . $this->name;
    }
}

?>