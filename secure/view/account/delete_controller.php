<?php
require_once('../../load.php');
load::load_file('view/account', 'account_imports.php');

$division_id = Parameters::read_post_input('division_id');

if (!empty($division_id)) {
    PlayerDAO::delete_by_id($division_id, Parameters::read_post_input('user_id'));
}

Footer::outputFooter();
?>