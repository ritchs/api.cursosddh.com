<?php
  require_once './../functions/users/users.php';

  $user_obj = new Users();
  
  $user_obj -> update_user($userid, $email, $name, $gender);

  $responses_obj -> success_response();