<?php
require_once '../functions/session/session.php' ;

class Login {

  private $dbtools_obj = null;
  private $responses_obj = null;
  private $session_obj = null;

  function __construct() {
    $this->dbtools_obj = new DB_Tools;
    $this->responses_obj = new Responses;
    $this->session_obj = new Session;
  }

  function login($email, $password) {

    if (!$tmp_user = $this-> dbtools_obj -> getRow('USERs', 'id, password', 'status="7" and email="'.$email.'"')) {
      $this->responses_obj -> error_response('U001', 'User not found');
    }

    if (!password_verify($password, $tmp_user['password'])) {
      $this->responses_obj -> error_response('U002', 'Invalid password');
    }

    $this -> session_obj -> clear_sessions($tmp_user['id']);
    $sessionkey = $this -> session_obj -> create_session($tmp_user['id']);

    $response = array(
      'session_key' => $sessionkey
    );

    $this->responses_obj->success_response($response);
  }

  function logout($userid) {
    $this -> session_obj -> clear_sessions($userid);
  }

}