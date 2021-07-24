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
      $andwhere .= " and p.id='$userid'";
    }

    $users = $this -> dbtools_obj -> getrows('PARTICIPANTs as p', 'p.id,p.name,p.date,c.name AS coursename,pl.name AS placename,p.constancy', "p.status=7 $andwhere",'INNER JOIN COURSe AS c ON p.id_course = c.id INNER JOIN PLACe AS pl ON p.id_course = pl.id');
    unset($users[0]);
    return array_values($users);
  }

  function add_user($name,$date,$id_course,$id_place,$constancy) {

    if ($tmp_id = $this-> dbtools_obj -> getValue('PARTICIPANTs', 'id', 'status="7" and name="'.$name.'"')) {
      $this->responses_obj -> error_response('U001', 'User already exists');
    }
  
    $fields = array(
      'name'=> $name,
      'date' => $date,
      'id_course' => $id_course, 
      'id_place' => $id_place,
      'constancy' => $constancy  
    );
  
    $userid = $this-> dbtools_obj -> insertrow('PARTICIPANTs', 7, $fields);

    return $userid;

  }
  function update_user($userid, $name,$date,$id_course, $id_place,$constancy) {

    if (!$tmp_id = $this-> dbtools_obj -> getValue('PARTICIPANTs', 'id','name','id_course','date','id_place','constancy', 'status="7" and id="'.$userid.'"')) {
      $this->responses_obj -> error_response('U003', 'User not found');
    }
    if ($tmp_id2 = $this-> dbtools_obj -> getValue('PARTICIPANTs', 'id', 'status="7" and email="'.$email.'" and id!="'.$userid.'"')) {
      $this->responses_obj -> error_response('U003', 'User with that email already exists');
    }
  
    $fields = array(
      'name'=> $name,
      'date' => $date,
      'id_course' => $id_course, 
      'id_place' => $id_place,
      'constancy' => $constancy      
    );
  
    $this-> dbtools_obj -> updaterow('PARTICIPANTs', 7, $fields, $userid);

  }

  function delete_user($userid) {
    
    if (!$tmp_id = $this-> dbtools_obj -> getValue('PARTICIPANTs', 'id', 'status="7" and id="'.$userid.'"')) {
      $this->responses_obj -> error_response('U004', 'User not found');
     
    }
    echo ($userid);
    $this -> dbtools_obj -> deleterow('PARTICIPANTs', $userid);
  }
}