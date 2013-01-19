<?php
abstract class AbstractData
{
    public function list_to_map($list, $field = 'id')
    {
        $map = array();
        foreach ($list as $list_item) {
            if (empty($map[$list_item->$field])) {
                $map[$list_item->$field] = $list_item;
            } else if (is_array($map[$list_item->$field])) {
                $map[$list_item->$field][] = $list_item;
            } else {
                $value_array = array();
                $value_array[] = $map[$list_item->$field];
                $map[$list_item->$field] = $value_array;
                $map[$list_item->$field][] = $list_item;
            }
        }
        return $map;
    }
}

?>