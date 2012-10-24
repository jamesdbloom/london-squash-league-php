<?php
require_once('../../load.php');
load::load_file('view/account', 'account_imports.php');

$division_id = Parameters::read_post_input('division_id');
$register = Parameters::read_post_input('re-register');
$unregister = Parameters::read_post_input('unregister');

if (!empty($division_id)) {
    if ($unregister) {
        PlayerDAO::update_status_by_division_id_and_user_id($division_id, Parameters::read_post_input('user_id'), Player::inactive);
    }
    if ($register) {
        PlayerDAO::update_status_by_division_id_and_user_id($division_id, Parameters::read_post_input('user_id'), Player::active);
    }
}

Footer::outputFooter();
?>