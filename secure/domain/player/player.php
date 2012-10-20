<?php
class Player
{
    public $id;

    public $user_id;

    public $division_id;

    public $league_id;

    public $status;

    const active = 'active';
    const unregistered = 'unregistered';

    function __construct($id, $user_id, $division_id, $league_id, $status)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->division_id = $division_id;
        $this->league_id = $league_id;
        $this->status = $status;
    }

    public function is_active() {
        return $this->status == self::active;
    }

    public function __toString()
    {
        return 'Id: ' . $this->id . ' User Id: ' . $this->user_id . ' Division Id: ' . $this->division_id;
    }
}

?>