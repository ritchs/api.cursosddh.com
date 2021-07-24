<?php

class DB_Tools {
  private $sqltoolsmode = "";
  private $response_obj = null;
  private $cleanup_obj = null;


  function __construct($type="") {
    $this->sqltoolsmode = $type;
    $this->response_obj = new Responses;
    $this->cleanup_obj = new Cleanup;    
  } 

  function error($numerror, $errormes, $query) {
      printf("error in query: %s, %s<br><br>%s<br>", $numerror, $errormes, $query);
      exit(); 
  }

  function removenumindex($array) {
    if($array) {
      foreach($array as $key => $value) {
        if(is_numeric($key)) {
          unset($array[$key]);
        }		
      }
      return($array);
    }
  }

  function parse_fields($fields) {
    $set = "";
    
    if($fields) {
      foreach ($fields as $field => $value) {
        $field = $this -> cleanup_obj -> cleanvar($field);
        $value = $this -> cleanup_obj -> cleanvar($value);
      
        if($field) {
          $set.="$field='$value', "; 
        }
      }	
      $set = substr($set, 0, -2);
      return($set);
    }	
  }

  function doquery($query) {
    $dbins = $this -> opendb();	

    $query = stripslashes( $query );
    if( $this -> $sqltoolsmode === "echo") {
      echo "<br>\n$query<br>\n";
    } else {
      if(!$result = mysqli_query( $dbins, $query )) {
        die($this -> error($dbins->error, mysqli_connect_error(), $query));
        exit();
      }
    }
  }

  function insertrow($tablename, $status, $fields) {
      $dbins = $this -> opendb();
  
      $now = time();
      $tablename = $this -> cleanup_obj -> cleanvar($tablename);
      $set = $this -> parse_fields($fields);  
      $set .=", status='$status', createtstamp='$now', updatetstamp='$now'";
      
  
      $query = "INSERT INTO $tablename SET $set"; 
      $query = stripslashes($query); 
    
      if($this -> $sqltoolsmode === "echo") {
        echo "\n<br>\n$query\n<br>\n";
      }  else {
        if(!$result = mysqli_query($dbins, $query)) {
          die($this -> error($dbins->error, mysqli_connect_error(), $query));          
        } else {
          $id = mysqli_insert_id($dbins);
        }
      }
      
      return $id;
  }

  function deleterow($tablename, $rowid) {
    $tablename = $this -> cleanup_obj -> cleanvar($tablename);
    
    $status = 13;
    $now = time();
      
    $query="update $tablename set status='$status', updatetstamp='$now' where id='$rowid' and status<>'$status'";
      echo "$query";
    if($this -> $sqltoolsmode === "echo") {
      echo( "<br>\n$query<br>\n" );
    } else {
      $this -> doquery($query);
    }
  }

  function updaterow($tablename, $rowstatus, $fields, $rowid = "", $whereid = "") {
    $tablename = $this -> cleanup_obj -> cleanvar($tablename);
  
    $set = $this -> parse_fields($fields);
  
    if($tablename and $set and ($rowid || $whereid)) {
      
      $now = time();
      
      $set.=", status='$rowstatus', updatetstamp='$now'";
      
      $query="UPDATE $tablename SET $set WHERE ";

      if($rowid) {
        $query .= "id='$rowid'";
      } else if($whereid) {
        $query .= $whereid;
      } else {
        echo "Missing rowid or whereid<br>";
        exit(); 
      }			
    
      $this -> doquery($query);
    } else {
      echo "Missing something in updaterow: table:$tablename | set:$set | id:$where<br>";
      exit(); 
    }
  }

  function getvalue($tablename, $field, $where, $joins="") {
    $dbins = $this -> opendb();	
  
    $tablename = $this -> cleanup_obj -> cleanvar($tablename);
    $query = "SELECT $field from $tablename $joins where $where";
    $query = stripslashes($query);
    
    if($this -> $sqltoolsmode === "echo") {
      echo "<br>\n$query<br>\n";
    }

    if(!$result = mysqli_query($dbins, $query)) {
      die($this -> error($dbins->error, mysqli_connect_error(), $query));	
    } else {
      $data_array = mysqli_fetch_row($result);
      $value = $data_array[0];
      mysqli_free_result($result);
    }
    return $value;
  }

  function getvalues($tablename, $field, $where, $joins="") {
    $dbins = $this -> opendb();
      
    $tablename = $this -> cleanup_obj -> cleanvar($tablename);
    $query = "SELECT $field FROM $tablename $joins WHERE $where";	
    
    $query = stripslashes($query);
    
    if($this -> $sqltoolsmode === "echo") {
      echo "<br>\n$query<br>\n";
    }
      
    if(!$result=mysqli_query($dbins, $query)) {
      die($this -> error($dbins->error, mysqli_connect_error(), $query));
    } else {
      $rows = mysqli_num_rows($result);
      for( $i=0; $i<$rows; $i++ ) {
        $data_array = mysqli_fetch_row($result);
        $values_array[$i] = $data_array[0];
      }
      mysqli_free_result($result);
    }
    return $values_array;
  }

  function getrow($tablename, $fields, $where, $joins="") {
    $dbins = $this -> opendb();
        
    $tablename = $this -> cleanup_obj -> cleanvar($tablename);
    $query = "SELECT $fields from $tablename $joins where $where";
    $query = stripslashes($query);
    
    if($this -> $sqltoolsmode === "echo") {
      echo( "<br>\n$query<br>\n" );
    }
    if(!$result=mysqli_query($dbins, $query)) {
      die($this -> error($dbins->error, mysqli_connect_error(), $query));
    } else {
      $data_array = $this -> removenumindex(mysqli_fetch_array($result));
      mysqli_free_result($result);
    }
    return $data_array;
  }

  function getrows($tablename, $fields, $where, $joins="") {
    $dbins = $this -> opendb();
        
    $tablename = $this -> cleanup_obj ->cleanvar($tablename);
    $query = "SELECT $fields from $tablename $joins where $where";
    $query = stripslashes($query);
    if($this -> $sqltoolsmode == "echo") {
      echo( "<br>\n$query<br>\n" );
    }
    if(!$result=mysqli_query($dbins, $query)) {
      die($this -> error( $dbins->error, mysqli_connect_error(), $query));
    } else {
      $row_array[0][0] = $rows = mysqli_num_rows($result);
      $row_array[0][1] = $fields = mysqli_num_fields($result);
      
      for($i=1; $i<=$rows; $i++) {
        $row_array[$i] = mysqli_fetch_array($result);
        foreach($row_array[$i] as $key => $value) {
          $row_array[$i] = $this -> removenumindex($row_array[$i]);
        }
      }
      mysqli_free_result($result);
    }
    return $row_array;
  }

  function opendb() {
    $host = "127.0.0.1";
    $user = "root";
    $pass = "P@ssw00rd";
    $database = "cursosddh";


    $dbins=mysqli_connect( "p:".$host, $user, $pass, $database );
    
    if( mysqli_connect_errno( $dbins ) )
    {
      $this -> $response_obj -> error_response('B001', 'DB Maintinance, please try in a few minutes' );
      exit();
    }
              
    return($dbins);
  }  
}