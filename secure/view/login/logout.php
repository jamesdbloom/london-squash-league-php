<?php
require_once('login_view_helper.php');

Session::logout();
Cookies::remove_cookie(Session::SSO_ID_COOKIE_NAME);

Headers::redirect_to_root();
?>