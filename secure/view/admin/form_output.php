<?php
function print_table_start($title, $class = '', $title_class = 'table_title', $title_id = '')
{
    print "<h2 class='$title_class' " . (!empty($title_id) ? " id=$title_id " : "") . ">$title</h2>";
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

function print_table_row($classes, $values, $cell_type = 'td')
{
    print "<tr>";
    foreach (array_keys($classes) as $key) {
        print "<" . $cell_type . " class='$classes[$key]'>" . (!empty($values[$key]) ? $values[$key] : "&nbsp;") . "</" . $cell_type . ">";
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

function print_recreation_confirm($table_type) {
    if (Session::is_administrator()) {

        Page::header(Link::Recreate_Tables);

        print "<h2 class='form_subtitle'>Are you sure you want to recreate all $table_type tables?</h2>";
        print "<form method='post' action='recreate_schema_controller.php'><div class='recreate_tables_confirm_form'>";
        print "<p class='submit'><input class='submit' type='submit' name='yes' value='yes'></p>";
        print "</div></form>";

        Page::footer();

    } else {

        Page::not_authorised();

    }
}

?>
