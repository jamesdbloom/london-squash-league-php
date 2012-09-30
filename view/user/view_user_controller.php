<?php
require_once('../../load.php');
load::load_file('domain/user', 'userDAO.php');
?>
<?php
$errors = new Error();
$id = Parameters::read_post_input('id');
$email = Parameters::read_post_input('email');
if (!empty($id)) {
    $user = UserDAO::get_by_id($id, $errors);
} else if (!empty($email)) {
    $user = UserDAO::get_by_email($email, $errors);
}
if ($errors->has_errors()) {
    echo $errors;
}
if (!empty($user)) {
    Session::print_hello_or_login_button();
    print "<table border='1'>\n";
    print "<tr><td>$user->id</td><td>$user->name</td><td>$user->email</td></tr>\n";
    print "</table>\n";
}
include '../layout/footer/footer.php';
?>