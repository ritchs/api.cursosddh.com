<?php
  $allowed_methods = ["post", "get", "delete"];
  
  // POST Variables
  $allowed_variables['post'] = ['email', 'password'];
  $required_variables['post'] = ['email', 'password'];
  
  //GET
  $allowed_variables['get'] = ['session_key'];
  $required_variables['get'] = ['session_key'];

  // DELETE Variables
  $allowed_variables['delete'] = ['userid'];
  $required_variables['delete'] = ['userid'];