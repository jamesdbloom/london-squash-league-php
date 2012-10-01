<?php
require_once('../../load.php');
load::load_file('domain/division', 'divisionDAO.php');
?>
<?php
$errors = new Error();
$id = Parameters::read_post_input('id');
$name = Parameters::read_post_input('name');
if (!empty($id)) {
    $division = DivisionDAO::get_by_id($id, $errors);
} else if (!empty($name)) {
    $division = DivisionDAO::get_by_name($name, $errors);
}
if ($errors->has_errors()) {
    echo $errors;
}
if (!empty($division)) {
    print "<table border='1'>\n";
    print "<tr><th>Id</td><td>Name</td><td>League Id</td></tr>\n";
    print "<tr><td>$division->id</td><td>$division->name</td><td>$division->league_id</td></tr>\n";
    print "</table>\n";
}
include '../layout/footer/footer.php';
?>