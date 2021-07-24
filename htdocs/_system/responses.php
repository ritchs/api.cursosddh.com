<?php

class Responses {

  function error_response($code, $message) {
    $response = array(
      'status' => false,
      'code' => $code,
      'message' => $message
    );

    $this -> send_response($response);
  }

  function success_response($data="") {
    $response = array(
      'status' => true,
      'data' => $data
    );

    $this -> send_response($response);
  }

  function send_response($response) {
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
  }

}