<?php
require_once('../../load.php');
load::load_file('domain/league', 'leagueDAO.php');
?>
<?php
$errors = new Error();
$id = Parameters::read_post_input('id');
$name = Parameters::read_post_input('name');
if (!empty($id)) {
    $league = LeagueDAO::get_by_id($id, $errors);
} else if (!empty($name)) {
    $league = LeagueDAO::get_by_name($name, $errors);
}
if ($errors->has_errors()) {
    echo $errors;
}
if (!empty($league)) {
    print "<table border='1'>\n";
    print "<tr><th>Id</td><td>Name</td><td>Club Id</td></tr>\n";
    print "<tr><td>$league->id</td><td>$league->name</td><td>$league->club_id</td></tr>\n";
    print "</table>\n";
}
include '../layout/footer/footer.php';
?>