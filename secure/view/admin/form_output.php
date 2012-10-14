<?php
function print_table_start($title, $class = '')
{
    print "<h2 class='table_title'>$title</h2>";
    print "<table class='$class'>";
}

function print_form($classes, $values, $field_ids = array(), $field_values = array(), $button = 'delete')
{
    print "<form method='post' action='delete_controller.php'>";
    foreach (array_keys($field_ids) as $key) {
        print "<input name='$field_ids[$key]' type='hidden' value='" . $field_values[$key] . "'>";
    }
    print "<tr>";
    foreach (array_keys($classes) as $key) {
        print "<td class='$classes[$key]'>" . (!empty($values[$key]) ? $values[$key] : "&nbsp;") . "</td>";
    }
    print "<td class='button last'><input type='submit' name='$button' value='$button'></td>";
    print "</tr>";
    print "</form>";
}

function print_table_row($classes, $values)
{
    print "<tr>";
    foreach (array_keys($classes) as $key) {
        print "<td class='$classes[$key]'>" . (!empty($values[$key]) ? $values[$key] : "&nbsp;") . "</td>";
    }
    print "</tr>";
}

function print_create_form_start($type)
{
    print "<form method='post' action='create_controller.php'>";
    print "<input name='type' type='hidden' value='$type'>";
}

function print_form_table_end()
{
    print "</form>";
    print "</table>";
}

?>
