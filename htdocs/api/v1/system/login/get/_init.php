<?php
require_once './../functions/session/session.php';

$session_obj = new Session();
$responses_obj = new Responses();

$valid_session = $session_obj -> check_session($session_key);
if ($valid_session) {
  $responses_obj -> success_response();
} else {
  $responses_obj -> error_response('L001', 'Invalid session key');
}