<?php
require_once('../../load.php');
load::load_file('domain/club', 'clubDAO.php');
load::load_file('domain/league', 'leagueDAO.php');
load::load_file('domain/division', 'divisionDAO.php');
load::load_file('domain/round', 'roundDAO.php');

$errors = new Error();
?>