<?php
require_once('../../load.php');
load::load_file('domain/user', 'userDAO.php');
?>

<html>
<head>
    <title>Users List</title>
</head>
<body>
<?php
$errors = new Error();
$user_list = UserDAO::get_all($errors);
if ($errors->has_errors()) {
    echo $errors;
}
if (count($user_list) > 0) {
    Session::print_hello_or_login_button();
    print "<table border='1'>\n";
    foreach ($user_list as $user)
        print "<tr><td>$user->id</td><td>$user->name</td><td>$user->email</td></tr>\n";
    print "</table>\n";
}
include '../layout/footer/footer.php';
?>
</body>
</html>