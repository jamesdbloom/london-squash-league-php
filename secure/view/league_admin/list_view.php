<?php
include '../admin/league_header.php';
?>
<!DOCTYPE>
<html>
<head>
    <title>Administration</title>
    <link rel="stylesheet" type="text/css" href="/secure/view/admin/admin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php

//
// READ DATABASE DATA
//
$club_list = ClubDAO::get_all($errors);
$league_list = LeagueDAO::get_all($errors);
$division_list = DivisionDAO::get_all($errors);
$round_list = RoundDAO::get_all($errors);
Error::print_errors($errors);
$club_map = list_to_map($club_list);
$league_map = list_to_map($league_list);
$division_map = list_to_map($division_list);
$round_map = list_to_map($round_list);

//
// CLUBS
//
print "<h2>Clubs</h2>";
print "<table>\n";
print "<tr><th class='id'>Id</th><th class='name'>Name</th><th class='address'>Address</th><th class='button'></th></tr>\n";
foreach ($club_list as $club) {
    print "<form method='post' action='delete_controller.php'>\n";
    print "<input name='club_id' type='hidden' value='" . $club->id . "'>\n";
    print "<tr><td class='id'>$club->id</td><td class='name'>$club->name</td><td class='address'>$club->address</td><td class='button'><input type='submit' name='delete' value='delete'></td></tr>\n";
    print "</form>\n";
}
print "<form method='post' action='create_controller.php'>\n";
print "<input name='type' type='hidden' value='club'>\n";
print "<tr><td class='id'></td><td class='name'><input name='name' type='text' pattern='.{3,25}' required='required'></td><td class='address'><input name='address' type='text' pattern='.{10,125}'></td><td class='button'><input type='submit' name='create' value='create'></td></tr>\n";
print "</form>\n";
print "</table>\n";

//
// LEAGUES
//
print "<h2>Leagues</h2>";
print "<table>\n";
print "<tr><th class='id'>Id</th><th class='name'>Club</th><th class='name'>League</th><th class='button'></th></tr>\n";
foreach ($league_list as $league) {
    $club = $club_map[$league->club_id];
    print "<form method='post' action='delete_controller.php'>\n";
    print "<input name='league_id' type='hidden' value='" . $league->id . "'>\n";
    print "<tr><td class='id'>$league->id</td><td class='name'>" . (!empty($club) ? $club->name : $league->club_id ) . "</td><td class='name'>$league->name</td><td class='button'><input type='submit' name='delete' value='delete'></td></tr>\n";
    print "</form>\n";
}
print "<form method='post' action='create_controller.php'>\n";
print "<input name='type' type='hidden' value='league'>\n";
print "<tr><td class='id'></td><td class='name'>";
if (count($club_list) > 0) {
    print "<select name='club_id'>";
    foreach ($club_list as $club) {
        print "<option value='" . $club->id . "''>$club->name</option>\n";
    }
    print "</select>";
}
print "</td><td class='name'><input name='name' type='text' pattern='.{3,25}' required='required'></td><td class='button'><input type='submit' name='create' value='create'></td></tr>\n";
print "</form>\n";
print "</table>\n";

//
// DIVISIONS
//
print "<h2>Divisions</h2>";
print "<table>\n";
print "<tr><th class='id'>Id</th><th class='name'>League</th><th class='name'>Division</th><th class='button'></th></tr>\n";
foreach ($division_list as $division) {
    $league = $league_map[$division->league_id];
    print "<form method='post' action='delete_controller.php'>\n";
    print "<input name='division_id' type='hidden' value='" . $division->id . "'>\n";
    print "<tr><td class='id'>$division->id</td><td class='name'>" . (!empty($league) ? $league->name : $division->league_id ) . "</td><td class='name'>$division->name</td><td class='button'><input type='submit' name='delete' value='delete'></td></tr>\n";
    print "</form>\n";
}
print "<form method='post' action='create_controller.php'>\n";
print "<input name='type' type='hidden' value='division'>\n";
print "<tr><td class='id'></td><td class='name'>";
if (count($league_list) > 0) {
    print "<select name='league_id'>";
    foreach ($league_list as $league) {
        print "<option value='" . $league->id . "''>$league->name</option>\n";
    }
    print "</select>";
}
print "</td><td class='name'><input name='name' type='text' pattern='.{3,25}' required='required'></td><td class='button'><input type='submit' name='create' value='create'></td></tr>\n";
print "</form>\n";
print "</table>\n";

print "<p><a href='recreate_tables.php'>Recreate Table</a></p>";
print "<p><a href='/secure'>Home</a></p>";

function list_to_map($list) {
    $map = array();
    foreach ($list as $list_item) {
        $map[$list_item->id] = $list_item;
    }
    return $map;
}
?>
</body>
</html>