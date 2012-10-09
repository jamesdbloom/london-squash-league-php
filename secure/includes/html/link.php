<?php
class Link
{
    public $url;

    public $text;

    function __construct($url, $text)
    {
        $this->url = $url;
        $this->text = $text;
    }

    public function __toString()
    {
        return "<a href='" . $this->url . "' title='" . $this->text . "'>" . $this->text . "</a>" ;
    }
}

?>