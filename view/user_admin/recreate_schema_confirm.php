<?php
require_once('../../load.php');
load::load_file('view/admin', 'form_output.php');

print_recreation_confirm(Link::root . Link::User_Admin_Recreate_Tables_Controller_Url, 'League');
?>
