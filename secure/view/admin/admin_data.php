<?php
class AdminData {
    public function list_to_map($list)
    {
        $map = array();
        foreach ($list as $list_item) {
            $map[$list_item->id] = $list_item;
        }
        return $map;
    }
}
?>