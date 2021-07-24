<?php
  require_once './../functions/participants/Participants.php';

  $user_obj = new Users();
  
  $userid = $user_obj -> add_user($name,$date,$id_course,$id_place,$constancy);
  if ($userid) {
    $data_response = array(
      'userid' => $userid
    );
    $responses_obj -> success_response($data_response);
  } else {
    $responses_obj -> error_response('U002', 'Something went wrong, please try again in a few minutes');
  }

