<?php
class Player
{
    public $id;

    public $user_id;

    public $division_id;

    function __construct($id, $user_id, $division_id)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->division_id = $division_id;
    }

    public function __toString()
    {
        return 'Id: ' . $this->id . ' User Id: ' . $this->user_id . ' Division Id: ' . $this->division_id;
    }
}

?>