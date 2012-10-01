<?php
require_once('../../load.php');
load::load_file('domain/session', 'sessionDAO.php');
?>
<?php
$errors = new Error();
SessionDAO::delete_by_user_id(Parameters::read_post_input('user_id'), $errors);
if ($errors->has_errors()) {
    echo $errors;
    include '../layout/footer/footer.php';
} else {
    Headers::set_redirect_header('/admin/admin/session/list_sessions_view.php');
}
?>