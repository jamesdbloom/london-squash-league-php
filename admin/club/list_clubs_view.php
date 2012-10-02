<?php
require_once('../../load.php');
load::load_file('domain/club', 'clubDAO.php');
load::load_file('domain/league', 'leagueDAO.php');
load::load_file('domain/division', 'divisionDAO.php');
?>

<html>
<head>
    <title>Clubs List</title>
    <style type="text/css">
        body {
            font-family: sans-serif;
        }
        table {
            border: 1px dashed;
            margin-bottom: 20px;
        }
        .id {
            width: 10%;
        }
        .name {
            width: 25%;
        }
        .address {
            width: 50%;
        }
        .button {
            width: 8%;
            border-right: 0px;
        }
        td {
            text-align: center;
            border-top: 1px dashed;
            border-right: 1px dashed;
        }
        input {
            width: 90%;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
$errors = new Error();


print "<h2>Clubs</h2>";
$club_list = ClubDAO::get_all($errors);
if ($errors->has_errors()) {
    echo $errors;
}
print "<table>\n";
print "<tr><th class='id'>Id</th><th class='name'>Name</th><th class='address'>Address</th><th class='button'></th></tr>\n";
foreach ($club_list as $club) {
    print "<form method='post' action='delete_club_controller.php'>\n";
    print "<input name='id' type='hidden' value='" . $club->id . "'>\n";
    print "<tr><td class='id'>$club->id</td><td class='name'>$club->name</td><td class='address'>$club->address</td><td class='button'><input type='submit' name='delete' value='delete'></td></tr>\n";
    print "</form>\n";
}
print "<form method='post' action='create_club_controller.php'>\n";
print "<tr><td class='id'></td><td class='name'><input name='name' type='text' required='required'></td><td class='address'><input name='address' type='text'></td><td class='button'><input type='submit' name='create' value='create'></td></tr>\n";
print "</form>\n";
print "</table>\n";


print "<h2>Leagues</h2>";
$league_list = LeagueDAO::get_all($errors);
if ($errors->has_errors()) {
    echo $errors;
}
print "<table>\n";
print "<tr><th class='id'>Id</th><th class='name'>Club</th><th class='name'>League</th><th class='button'></th></tr>\n";
foreach ($league_list as $league) {
    $club = ClubDAO::get_by_id($league->club_id, $errors);
    if ($errors->has_errors()) {
        echo $errors;
    }
    if (!empty($club)) {
        print "<form method='post' action='delete_league_controller.php'>\n";
        print "<input name='id' type='hidden' value='" . $club->id . "'>\n";
        print "<tr><td class='id'>$league->id</td><td class='name'>$club->name</td><td class='name'>$league->name</td><td class='button'><input type='submit' name='delete' value='delete'></td></tr>\n";
        print "</form>\n";
    }
}
print "<form method='post' action='create_league_controller.php'>\n";
print "<tr><td class='id'></td><td class='name'>";
$errors = new Error();
$club_list = ClubDAO::get_all($errors);
if ($errors->has_errors()) {
    echo $errors;
}
if (count($club_list) > 0) {
    print "<select name='club_id'>";
    foreach ($club_list as $club) {
        print "<option value='" . $club->id . "''>$club->name</option>\n";
    }
    print "</select>";
}
print "</td><td class='name'><input name='name' type='text'></td><td class='button'><input type='submit' name='create' value='create'></td></tr>\n";
print "</form>\n";
print "</table>\n";


print "<h2>Divisions</h2>";
$division_list = DivisionDAO::get_all($errors);
if ($errors->has_errors()) {
    echo $errors;
}
print "<table>\n";
print "<tr><th class='id'>Id</th><th class='name'>League</th><th class='name'>Division</th><th class='button'></th></tr>\n";
foreach ($division_list as $division) {
    $league = LeagueDAO::get_by_id($division->league_id, $errors);
    if ($errors->has_errors()) {
        echo $errors;
    }
    if (!empty($league)) {
        print "<form method='post' action='delete_division_controller.php'>\n";
        print "<input name='id' type='hidden' value='" . $club->id . "'>\n";
        print "<tr><td class='id'>$division->id</td><td class='name'>$league->name</td><td class='name'>$division->name</td><td class='button'><input type='submit' name='delete' value='delete'></td></tr>\n";
        print "</form>\n";
    }
}
print "<form method='post' action='create_division_controller.php'>\n";
print "<tr><td class='id'></td><td class='name'>";
$errors = new Error();
$league_list = LeagueDAO::get_all($errors);
if ($errors->has_errors()) {
    echo $errors;
}
if (count($league_list) > 0) {
    print "<select name='league_id'>";
    foreach ($league_list as $league) {
        print "<option value='" . $league->id . "''>$league->name</option>\n";
    }
    print "</select>";
}
print "</td><td class='name'><input name='name' type='text'></td><td class='button'><input type='submit' name='create' value='create'></td></tr>\n";
print "</form>\n";
print "</table>\n";
print '<p><a href="/admin/admin/club/recreate_club_table.php">Recreate Table</a></p>';
include '../layout/footer/footer.php';
?>
</body>
</html>