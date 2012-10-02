<?php
require_once('../../load.php');
load::load_file('domain/club', 'clubDAO.php');
load::load_file('domain/league', 'leagueDAO.php');
load::load_file('domain/division', 'divisionDAO.php');
$errors = new Error();
DivisionDAO::create_division_schema($errors);
LeagueDAO::create_league_schema($errors);
ClubDAO::create_club_schema($errors);
if ($errors->has_errors()) {
    ?>
<html>
<head>
    <title>Recreate Table</title>
</head>
<body>
    <?php
    echo $errors;
    include '../layout/footer/footer.php';
    ?>
</body>
</html>
<?php
} else {
    Headers::set_redirect_header('/admin/admin/club/list_clubs_view.php');
}
?>