<?php
  define('SYSTEM_HOST', $_SERVER['HTTP_HOST']);
  define('SYSTEM_REQUEST_URI', $_SERVER['REQUEST_URI']);
  define('API_METHOD', strtolower($_SERVER['REQUEST_METHOD']));

  $cleanup_obj = new Cleanup();

  // Break URL
  $tmp_request_uri = SYSTEM_REQUEST_URI;
  $tmp_request_uri = trim($tmp_request_uri, '/');
  $break_url = explode('/', $tmp_request_uri);
  $version = $break_url[0];
  $folder = $break_url[1];
  $subfolder = $break_url[2];
  $subfolder = preg_replace('/[^a-z]+(.+)/i', '', $subfolder);

  // Get PUT Variables
  if (API_METHOD === 'put') {
    file_get_contents('php://input');
    parse_str(file_get_contents('php://input'), $_PUT);

    $_REQUEST = array_merge($_REQUEST, $_PUT);
  }

  // Cleanup Variables
  $_REQUEST = $cleanup_obj -> cleanvar($_REQUEST);

  // Public APIs
  $system_public_apis = ['system/login'];