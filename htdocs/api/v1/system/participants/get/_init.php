<?php
  require_once './../functions/participants/Participants.php';

  $user_obj = new Users();
  
  $users = $user_obj -> get_users($userid);

  $responses_obj -> success_response($users);