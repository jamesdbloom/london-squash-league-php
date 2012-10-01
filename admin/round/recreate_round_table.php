<?php
require_once('../../load.php');
load::load_file('domain/round', 'roundDAO.php');
?>
<html>
<head>
    <title>Recreate Table</title>
</head>
<body>
<?php
$errors = new Error();
RoundDAO::create_round_schema($errors);
if ($errors->has_errors()) {
    echo $errors;
}
include '../layout/footer/footer.php';
?>
</body>
</html>