<?php
require_once('../../load.php');
load::load_file('domain/club', 'clubDAO.php');
?>
<?php
$errors = new Error();
$id = Parameters::read_post_input('id');
$name = Parameters::read_post_input('name');
if (!empty($id)) {
    $club = ClubDAO::get_by_id($id, $errors);
} else if (!empty($name)) {
    $club = ClubDAO::get_by_name($name, $errors);
}
if ($errors->has_errors()) {
    echo $errors;
}
if (!empty($club)) {
    print "<table border='1'>\n";
    print "<tr><th>Id</td><td>Name</td><td>Address</td></tr>\n";
    print "<tr><td>$club->id</td><td>$club->name</td><td>$club->address</td></tr>\n";
    print "</table>\n";
}
include '../layout/footer/footer.php';
?>