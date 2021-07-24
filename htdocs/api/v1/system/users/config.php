<?php
  $allowed_methods = ["post", "get", "put", "delete"];
  
  //GET Variables
  $allowed_variables['get'] = ['userid'];
  $required_variables['get'] = [];

  // POST Variables
  $allowed_variables['post'] = [ 'email','password'];
  $required_variables['post'] = ['email', 'password'];

  // PUT Variables
  $allowed_variables['put'] = [ 'email', 'userid'];
  $required_variables['put'] = ['userid', 'email'];

  // DELETE Variables
  $allowed_variables['delete'] = ['userid'];
  $required_variables['delete'] = ['userid'];