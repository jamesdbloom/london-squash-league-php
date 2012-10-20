<?php
class Round
{
    public $id;

    public $division_id;

    public $start;

    public $end;

    public $name;

    public $status;

    const not_started = 'not_started';
    const inplay = 'inplay';
    const finished = 'finished';

    function __construct($id, $division_id, $start, $end)
    {
        $this->id = $id;
        $this->division_id = $division_id;
        $this->start = $start;
        $this->end = $end;
        if ($start >= time()) {
            $this->status = self::not_started;
        } else if ($start <= time() && $end >= time()) {
            $this->status = self::inplay;
        } else if ($end <= time()) {
            $this->status = self::finished;
        } else {
            $this->status = 'unknown';
        }

        $this->name = "&#40;" . date('d-M-Y', $this->start) . " &ndash; " . date('d-M-Y', $this->end) . "&#41;";
    }

    public function is_inplay()
    {
        return $this->status == self::inplay;
    }

    public function is_not_started()
    {
        return $this->status == self::not_started;
    }

    public function __toString()
    {
        return 'Id: ' . $this->id . ' Division Id: ' . $this->division_id . ' Start: ' . $this->start . ' End: ' . $this->end;
    }
}

?>