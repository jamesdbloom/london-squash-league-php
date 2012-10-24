<?php
require_once('../../load.php');

Session::logout();
Cookies::remove_cookie(Session::SSO_ID_COOKIE_NAME);

Headers::redirect_to_landing_page();
?>