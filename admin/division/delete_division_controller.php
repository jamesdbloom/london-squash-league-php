<?php
require_once('../../load.php');
load::load_file('domain/division', 'divisionDAO.php');
?>
<?php
$errors = new Error();
DivisionDAO::delete_by_id(Parameters::read_post_input('id'), $errors);
if ($errors->has_errors()) {
    echo $errors;
    include '../layout/footer/footer.php';
} else {
    Headers::set_redirect_header('/admin/admin/division/list_divisions_view.php');
}
?>