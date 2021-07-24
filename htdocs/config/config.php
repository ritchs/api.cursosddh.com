<?php
  header('Access-Control-Allow-Origin: *');
  header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
  header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
  date_default_timezone_set('America/Mexico_City');

  require_once('../_system/autoloader.php');
  require_once('../_system/variables.php');
  require_once('../_system/dbtools.php');
  require_once('../functions/session/session.php');

  $responses_obj = new Responses();
  $session_obj = new Session();
  
  if (count($break_url) < 3 || count($break_url) > 4) {
    $responses_obj -> error_response('S001', 'Invalid API');
    exit();
  }

  // Version
  if (!preg_match('/^v[0-9]+$/', $version)) {
    $responses_obj -> error_response('V001', 'Invalid Version');
    exit();
  }
  
  // Path
  $path = "../api/$version/$folder/$subfolder";
  if (!file_exists("$path/config.php")) {
    $responses_obj -> error_response('P001', 'API not found');
    exit();
  }
  include_once("$path/config.php");

  // Path Version
  $path_method = "$path/".API_METHOD."/_init.php";
  if (!file_exists($path_method)) {
    $responses_obj -> error_response('P002', 'API not found');
    exit();
  }

  // CheckSession
  $api_request = "$folder/$subfolder";

  if (!in_array($api_request, $system_public_apis)) {
    // print_r($_SERVER);
    if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] !== 'sessionkey') {
      // header('WWW-Authenticate: Basic');
      // header('HTTP/1.0 401 Unauthorized'); 
      $responses_obj -> error_response('S001', 'Invalid session key');   
      exit;
    } 
    
    define('SESSION_KEY', $_SERVER['PHP_AUTH_PW']);
  
    $valid_session = $session_obj -> check_session(SESSION_KEY);
    if (!$valid_session) {
      $responses_obj -> error_response('S002', 'Invalid session key');
      exit();
    }  
  }

  // Allowed Method
  if (!in_array(API_METHOD, $allowed_methods)) {
    $responses_obj -> error_response('P003', 'API not found');
    exit();
  }

  // Allowed variables
  $tmp_allowed = $allowed_variables[API_METHOD];
  foreach($_REQUEST as $variable => $value) {
    if (!in_array($variable, $tmp_allowed)) {
      unset($_REQUEST[$variable]);
    }
  }

  // Required variables
  $tmp_required = $required_variables[API_METHOD];

  foreach($tmp_required as $variable) {
    if (!array_key_exists($variable, $_REQUEST)) {
      $responses_obj -> error_response('VR001', "Missing info: $variable");
      exit();
    }
  }
  
  // Magic variables
  foreach($_REQUEST as $variable => $value) {
    $$variable = $value;
  }
  include_once($path_method);
