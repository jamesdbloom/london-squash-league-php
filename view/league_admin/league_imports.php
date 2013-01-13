<?php
require_once('../../load.php');
load::load_file('domain/club', 'clubDAO.php');
load::load_file('domain/league', 'leagueDAO.php');
load::load_file('domain/division', 'divisionDAO.php');
load::load_file('domain/division', 'divisionSize.php');
load::load_file('domain/round', 'roundDAO.php');
load::load_file('domain/match', 'matchDAO.php');
load::load_file('domain/player', 'playerDAO.php');
load::load_file('domain/ranking', 'rankingDAO.php');
load::load_file('view/admin', 'footer.php');
?>