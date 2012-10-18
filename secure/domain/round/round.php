<?php
class Round
{
    public $id;

    public $division_id;

    public $start;

    public $end;

    public $name;

    function __construct($id, $division_id, $start, $end)
    {
        $this->id = $id;
        $this->division_id = $division_id;
        $this->start = $start;
        $this->end = $end;
        $this->name = "&#40;" . date('d-M-Y', $this->start) . " &ndash; " . date('d-M-Y', $this->end) . "&#41;";
    }

    public function __toString()
    {
        return 'Id: ' . $this->id . ' Division Id: ' . $this->division_id . ' Start: ' . $this->start . ' End: ' . $this->end;
    }
}

?>