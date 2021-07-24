<?php
require_once './../functions/users/login.php';

$login_obj = new Login();

$login_obj -> logout($userid);

$responses_obj -> success_response();

