<?php
class League
{
    public $id;

    public $club_id;

    public $name;

    function __construct($id, $club_id, $name)
    {
        $this->id = $id;
        $this->club_id = $club_id;
        $this->name = $name;
    }

    public function __toString()
    {
        return 'Id: ' . $this->id . ' Club Id: ' . $this->club_id . ' Name: ' . $this->name . '<br/>';
    }
}

?>