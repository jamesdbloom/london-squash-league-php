<?php
require_once('../../load.php');
load::load_file('domain/round', 'roundDAO.php');
?>

<html>
<head>
    <title>Rounds List</title>
</head>
<body>
<?php
$errors = new Error();
$round_list = RoundDAO::get_all($errors);
if ($errors->has_errors()) {
    echo $errors;
}
if (count($round_list) > 0) {
    print "<table border='1'>\n";
    print "<tr><th>Id</td><td>Division Id</td><td>Start</td><td>End</td></tr>\n";
    foreach ($round_list as $round)
        print "<tr><td>$round->id</td><td>$round->division_id</td><td>$round->start</td><td>$round->end</td></tr>\n";
    print "</table>\n";
}
include '../layout/footer/footer.php';
?>
</body>
</html>