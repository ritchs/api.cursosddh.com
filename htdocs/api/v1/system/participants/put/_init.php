<?php
  require_once './../functions/participants/Participants.php';

  $user_obj = new Users();
  
  $user_obj -> update_user($userid,$name,$date,$id_course, $id_place,$constancy);

  $responses_obj -> success_response();