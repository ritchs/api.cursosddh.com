<?php
  require_once './../functions/course/course.php';

  $user_obj = new Users();
  
  $user_obj -> delete_user($userid);

  $responses_obj -> success_response();