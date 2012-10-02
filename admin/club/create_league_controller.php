<?php
require_once('../../load.php');
load::load_file('domain/league', 'leagueDAO.php');
?>
<?php
$errors = new Error();
$result = LeagueDAO::create(
    Parameters::read_post_input('club_id'),
    Parameters::read_post_input('name'),
    $errors
);

if ($errors->has_errors()) {
    echo $errors;
    include '../layout/footer/footer.php';
} else {
    Headers::set_redirect_header('/admin/admin/club/list_clubs_view.php');
}
?>