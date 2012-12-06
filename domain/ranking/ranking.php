<?php
class Ranking
{
    public $player_id;

    public $name;

    public $email;

    public $division;

    public $league;

    public $relative_position;

    function __construct($player_id, $name, $email, $division, $league, $relative_position)
    {
        $this->player_id = $player_id;
        $this->name = $name;
        $this->email = $email;
        $this->division = $division;
        $this->league = $league;
        $this->relative_position = $relative_position;
    }

    public function __toString()
    {
        return 'Player Id: ' . $this->player_id . ' Name: ' . $this->name . ' Email: ' . $this->email . ' Division: ' . $this->division . ' League: ' . $this->league . ' Relative Position: ' . $this->relative_position;
    }
}

?>