<?php
require_once('../../load.php');
load::load_file('domain/user', 'userDAO.php');
?>
<?php
$errors = new Error();
UserDAO::delete_by_id(Parameters::read_post_input('id'), $errors);
if ($errors->has_errors()) {
    echo $errors;
    include '../layout/footer/footer.php';
} else {
    Headers::set_redirect_header('/admin/view/user/list_users_view.php');
}
?>