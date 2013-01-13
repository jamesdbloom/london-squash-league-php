<?php
class Division
{
    public $id;

    public $league_id;

    public $round_id;

    public $name;

    function __construct($id, $league_id, $round_id, $name)
    {
        $this->id = $id;
        $this->league_id = $league_id;
        $this->round_id = $round_id;
        $this->name = $name;
    }

    public function __toString()
    {
        return 'Id: ' . $this->id . ' League Id: ' . $this->league_id . ' Round Id: ' . $this->round_id . ' Name: ' . $this->name . '<br/>';
    }
}

?>