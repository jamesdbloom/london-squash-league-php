<?php
require_once('../../load.php');
load::load_file('domain/league', 'league.php');
load::load_file('domain/league', 'leagueDAO.php');
?>

<html>
<head>
    <title>Leagues List</title>
</head>
<body>
<?php
$errors = new Error();
$league_list = LeagueDAO::get_all($errors);
if ($errors->has_errors()) {
    echo $errors;
}
if (count($league_list) > 0) {
    print "<table border='1'>\n";
    print "<tr><th>Id</td><td>Club Id</td><td>Name</td></tr>\n";
    foreach ($league_list as $league)
        print "<tr><td>$league->id</td><td>$league->club_id</td><td>$league->name</td></tr>\n";
    print "</table>\n";
}
include '../layout/footer/footer.php';
?>
</body>
</html>