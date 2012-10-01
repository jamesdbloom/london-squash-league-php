<?php
require_once('../../load.php');
load::load_file('domain/club', 'clubDAO.php');
?>
<html>
<head>
    <title>Recreate Table</title>
</head>
<body>
<?php
$errors = new Error();
ClubDAO::create_club_schema($errors);
if ($errors->has_errors()) {
    echo $errors;
}
include '../layout/footer/footer.php';
?>
</body>
</html>