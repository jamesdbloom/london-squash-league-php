<?php
require_once('../../load.php');
load::load_file('view/admin', 'account_imports.php');

$type = Parameters::read_post_input('type');
if ($type == 'player') {
    PlayerDAO::create(
        Parameters::read_post_input('user_id'),
        Parameters::read_post_input('division_id')
    );
}

Footer::outputFooter();
?>