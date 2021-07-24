<?php

class Session {

  private $dbtools_obj = null;
  private $responses_obj = null;

  function __construct() {
    $this->dbtools_obj = new DB_Tools;
    $this->responses_obj = new Responses;
  }

  function create_session($userid) {
    
    $fields_add = array('userid' => $userid);

    $sessionid = $this-> dbtools_obj -> insertrow('SESSION', 7, $fields_add);

    $sessionkey = hash( 'sha256', $sessionid);
    $fields_update = array('sessionkey' => $sessionkey);
    
    $this-> dbtools_obj -> updaterow('SESSION', 7, $fields_update, $sessionid);    

    return $sessionkey;
  }

  function clear_sessions($userid) {

    $fields_update = array('userid' => $userid);
    $this -> dbtools_obj -> updaterow('SESSION', 13, $fields_update, '', "userid='$userid' and status='7'");

  }

  function check_session($session_key) {

    if (!$tmp_session = $this -> dbtools_obj -> getrow('SESSION', 'id, createtstamp, userid', "status='7' and sessionkey='$session_key'")) {
      return false;
    }

    $onedaybefore = strtotime('-1 day', time());
    
    if ($tmp_session['createtstamp'] < $onedaybefore) {
      $this -> clear_sessions($tmp_session['userid']);
      return false;
    }

    return true;

  }
}
