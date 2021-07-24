<?php
  require_once './../functions/place/place.php';

  $user_obj = new Users();
  
  $user_obj -> delete_user($userid);

  $responses_obj -> success_response();