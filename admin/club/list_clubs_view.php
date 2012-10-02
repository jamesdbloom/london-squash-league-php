<?php
require_once('../../load.php');
load::load_file('domain/club', 'clubDAO.php');
?>

<html>
<head>
    <title>Clubs List</title>
</head>
<body>
<?php
$errors = new Error();
$club_list = ClubDAO::get_all($errors);
if ($errors->has_errors()) {
    echo $errors;
}
if (count($club_list) > 0) {
    print "<table border='1'>\n";
    print "<tr><th>Id</td><td>Name</td><td>Address</td></tr>\n";
    foreach ($club_list as $club)
        print "<tr><td>$club->id</td><td>$club->name</td><td>$club->address</td></tr>\n";
    print "</table>\n";
}
include '../layout/footer/footer.php';
?>
</body>
</html>