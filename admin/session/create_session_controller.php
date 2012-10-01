<?php
require_once('../../load.php');
load::load_file('domain/session', 'sessionDAO.php');
?>
<?php
$errors = new Error();
$password_check = Parameters::read_post_input('password_check');
$password = Parameters::read_post_input('password');
$result = SessionDAO::create(
    Session::generate_session_id(Parameters::read_post_input('user_id'), $errors),
    Parameters::read_post_input('user_id'),
    Parameters::read_post_input('status'),
    $errors
);

if ($errors->has_errors()) {
    echo $errors;
    include '../layout/footer/footer.php';
} else {
    Headers::set_redirect_header('/admin/admin/session/list_sessions_view.php');
}
?>