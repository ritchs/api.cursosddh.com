<?php

class Users {

  private $dbtools_obj = null;
  private $responses_obj = null;

  function __construct() {
    $this->dbtools_obj = new DB_Tools;
    $this->responses_obj = new Responses;
  }

  function get_users($userid="") {
    $andwhere = '';

    if ($userid) {
      $andwhere .= " and id='$userid'";
    }

    $users = $this -> dbtools_obj -> getrows('COURSe', 'id, name', "status=7 $andwhere");
    unset($users[0]);
    return array_values($users);
  }

  function add_user($name) {

    if ($tmp_id = $this-> dbtools_obj -> getValue('COURSe','id', 'status="7" and name="'.$name.'"')) {
      $this->responses_obj -> error_response('U001', 'User already exists');
    }

    $fields = array(
      'name' => $name
    );
  
    $userid = $this-> dbtools_obj -> insertrow('COURSe', 7, $fields);

    return $userid;

  }

  function update_user($userid, $name) {

    if (!$tmp_id = $this-> dbtools_obj -> getValue('COURSe', 'id', 'status="7" and id="'.$userid.'"')) {
      $this->responses_obj -> error_response('U003', 'course not found');
    }
    if ($tmp_id2 = $this-> dbtools_obj -> getValue('COURSe', 'id', 'status="7" and name="'.$name.'" and id!="'.$userid.'"')) {
      $this->responses_obj -> error_response('U003', 'course with that name already exists');
    }
  
    $fields = array(
      'name' => $name      
    );
  
    $this-> dbtools_obj -> updaterow('COURSe', 7, $fields, $userid);

  }

  function delete_user($userid) {
    
    if (!$tmp_id = $this-> dbtools_obj -> getValue('COURSe', 'id', 'status="7" and id="'.$userid.'"')) {
      $this->responses_obj -> error_response('U004', 'course not found');
    }

    $this -> dbtools_obj -> deleterow('COURSe', $userid);
  }
}