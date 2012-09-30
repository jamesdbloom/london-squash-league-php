<?php
require_once('../../load.php');
load::load_file('domain/session', 'sessionDAO.php');
?>
<html>
<head>
    <title>Recreate Table</title>
</head>
<body>
<?php
$errors = new Error();
SessionDAO::create_session_schema($errors);
if ($errors->has_errors()) {
    echo $errors;
}
include '../layout/footer/footer.php';
?>
</body>
</html>