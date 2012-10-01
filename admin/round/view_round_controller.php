<?php
require_once('../../load.php');
load::load_file('domain/round', 'roundDAO.php');
?>
<?php
$errors = new Error();
$id = Parameters::read_post_input('id');
if (!empty($id)) {
    $round = RoundDAO::get_by_id($id, $errors);
}
if ($errors->has_errors()) {
    echo $errors;
}
if (!empty($round)) {
    print "<table border='1'>\n";
    print "<tr><th>Id</td><td>Division Id</td><td>Start</td><td>End</td></tr>\n";
    print "<tr><td>$round->id</td><td>$round->division_id</td><td>$round->start</td><td>$round->end</td></tr>\n";
    print "</table>\n";
}
include '../layout/footer/footer.php';
?>