<?php
require_once('../../load.php');
load::load_file('view/account', 'account_imports.php');

$type = Parameters::read_post_input('type');
if ($type == 'player') {
    PlayerDAO::create(
        Parameters::read_post_input('user_id'),
        Parameters::read_post_input('league_id')
    );
}

Footer::outputAccountFooter();
?>