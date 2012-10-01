<?php
require_once('../../load.php');
load::load_file('domain/division', 'division.php');
load::load_file('domain/division', 'divisionDAO.php');
?>

<html>
<head>
    <title>Divisions List</title>
</head>
<body>
<?php
$errors = new Error();
$division_list = DivisionDAO::get_all($errors);
if ($errors->has_errors()) {
    echo $errors;
}
if (count($division_list) > 0) {
    print "<table border='1'>\n";
    print "<tr><th>Id</td><td>League Id</td><td>Name</td></tr>\n";
    foreach ($division_list as $division)
        print "<tr><td>$division->id</td><td>$division->league_id</td><td>$division->name</td></tr>\n";
    print "</table>\n";
}
include '../layout/footer/footer.php';
?>
</body>
</html>