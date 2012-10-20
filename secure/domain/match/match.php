<?php
class Match
{
    public $id;

    public $player_one_id;

    public $player_two_id;

    public $round_id;

    public $division_id;

    function __construct($id, $player_one_id, $player_two_id, $round_id, $division_id)
    {
        $this->id = $id;
        $this->player_one_id = $player_one_id;
        $this->player_two_id = $player_two_id;
        $this->round_id = $round_id;
        $this->division_id = $division_id;
    }

    public function __toString()
    {
        return 'Id: ' . $this->id
            . ' Player One Id: ' . $this->player_one_id
            . ' Player Two Id: ' . $this->player_two_id
            . ' Round Id: ' . $this->round_id;
    }
}

?>