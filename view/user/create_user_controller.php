<?php
require_once('../../load.php');
load::load_file('domain/user', 'userDAO.php');
?>
<?php
function is_validate_inputs($password_check, $password, Error $errors)
{
    if ($password_check == $password) {
        return true;
    } else {
        $errors->add('password_error', "The password do not match please try again");
    }
}

$errors = new Error();
$password_check = Parameters::read_post_input('password_check');
$password = Parameters::read_post_input('password');
if (is_validate_inputs($password_check, $password, $errors)) {
    $result = UserDAO::create(
        Parameters::read_post_input('name'),
        Parameters::read_post_input('password'),
        Parameters::read_post_input('email'),
        Parameters::read_post_input('mobile'),
        ' ',
        $errors
    );
}
if ($errors->has_errors()) {
    echo $errors;
    include '../layout/footer/footer.php';
} else {
    Headers::set_redirect_header('/admin/view/user/list_users_view.php');
}
?>