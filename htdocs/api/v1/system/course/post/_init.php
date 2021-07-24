<?php
  require_once './../functions/course/course.php';

  $user_obj = new Users();
  
  $userid = $user_obj -> add_user($name);

  if ($userid) {
    $data_response = array(
      'userid' => $userid
    );
    $responses_obj -> success_response($data_response);
  } else {
    $responses_obj -> error_response('U002', 'Something went wrong, please try again in a few minutes');
  }

