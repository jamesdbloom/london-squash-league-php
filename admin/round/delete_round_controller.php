<?php
require_once('../../load.php');
load::load_file('domain/round', 'roundDAO.php');
?>
<?php
$errors = new Error();
RoundDAO::delete_by_id(Parameters::read_post_input('id'), $errors);
if ($errors->has_errors()) {
    echo $errors;
    include '../layout/footer/footer.php';
} else {
    Headers::set_redirect_header('/admin/admin/round/list_rounds_view.php');
}
?>