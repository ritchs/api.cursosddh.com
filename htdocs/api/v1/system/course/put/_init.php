<?php
  require_once './../functions/course/course.php';

  $user_obj = new Users();
  
  $user_obj -> update_user($userid, $name );

  $responses_obj -> success_response();