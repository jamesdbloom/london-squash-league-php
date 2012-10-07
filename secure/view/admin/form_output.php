<?php
function print_table_start($title)
{
    print "<h2>$title</h2>";
    print "<table>";
}

function print_delete_form($id_field_name, $classes, $values)
{
    print "<form method='post' action='delete_controller.php'>\n";
    print "<input name='$id_field_name' type='hidden' value='" . $values[0] . "'>\n";
    print "<tr>";
    foreach (array_keys($classes) as $key) {
        print "<td class='$classes[$key]'>" . (!empty($values[$key]) ? $values[$key] : "&nbsp;") . "</td>";
    }
    print "<td class='button'><input type='submit' name='delete' value='delete'></td>";
    print "</tr>";
    print "</form>";
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
