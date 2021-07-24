<?php
  require_once './../functions/place/place.php';

  $user_obj = new Users();
  
  $users = $user_obj -> get_users($userid);

  $responses_obj -> success_response($users);