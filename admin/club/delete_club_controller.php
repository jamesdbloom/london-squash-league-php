<?php
require_once('../../load.php');
load::load_file('domain/club', 'clubDAO.php');
?>
<?php
$errors = new Error();
ClubDAO::delete_by_id(Parameters::read_post_input('id'), $errors);
if ($errors->has_errors()) {
    echo $errors;
    include '../layout/footer/footer.php';
} else {
    Headers::set_redirect_header('/admin/admin/club/list_clubs_view.php');
}
?>