<?php
  require_once './../functions/users/users.php';

  $user_obj = new Users();
  
  $user_obj -> delete_user($userid);

  $responses_obj -> success_response();