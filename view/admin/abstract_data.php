<?php
abstract class AbstractData {
    public function list_to_map($list, $field = 'id')
    {
        $map = array();
        foreach ($list as $list_item) {
            $map[$list_item->$field] = $list_item;
        }
        return $map;
    }
}
?>