<?php

require_once './../functions/users/login.php';

$login_obj = new Login();

$userid = $login_obj -> login($email, $password);

