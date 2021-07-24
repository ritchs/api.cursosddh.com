<?php
  require_once './../functions/users/users.php';

  $user_obj = new Users();
  
  $userid = $user_obj -> add_user($email,$password);

  if ($userid) {
    $data_response = array(
      'userid' => $userid
    );
    
    $responses_obj -> success_response($data_response);
  } else {
    $responses_obj -> error_response('U002', 'Something went wrong, please try again in a few minutes');
  }

