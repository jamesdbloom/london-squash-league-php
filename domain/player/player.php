<?php
class Player
{
    public $id;

    public $user_id;

    public $division_id;

    public $league_id;

    public $seed;

    public $status;

    const active = 'active';
    const inactive = 'inactive';

    function __construct($id, $user_id, $division_id, $league_id, $seed, $status)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->division_id = $division_id;
        $this->league_id = $league_id;
        $this->seed = $seed;
        $this->status = $status;
    }

    public function is_active()
    {
        return $this->status == self::active;
    }

    public function __toString()
    {
        return 'Id: ' . $this->id . ' User Id: ' . $this->user_id . ' Division Id: ' . $this->division_id . ' League Id: ' . $this->league_id . ' Seed: ' . $this->seed . ' Status: ' . $this->status . '<br/>';
    }
}

?>