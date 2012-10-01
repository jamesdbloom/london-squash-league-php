<?php
require_once('../../load.php');
load::load_file('domain/division', 'divisionDAO.php');
?>
<html>
<head>
    <title>Recreate Table</title>
</head>
<body>
<?php
$errors = new Error();
DivisionDAO::create_division_schema($errors);
if ($errors->has_errors()) {
    echo $errors;
}
include '../layout/footer/footer.php';
?>
</body>
</html>