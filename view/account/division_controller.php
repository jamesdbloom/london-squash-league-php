<?php
require_once('../../load.php');
load::load_file('view/account', 'account_imports.php');

$player_id = Parameters::read_post_input('player_id');
$register = Parameters::read_post_input('re-register');
$unregister = Parameters::read_post_input('unregister');
$user_id = Parameters::read_request_input('user_id');

if (!empty($player_id)) {
    if ($unregister) {
        PlayerDAO::update_status_by_id($player_id, Player::inactive);
    }
    if ($register) {
        PlayerDAO::update_status_by_id($player_id, Player::active);
    }
}

Footer::outputAccountFooter((!empty($user_id) ? '?user_id=' . $user_id : ''));
?>