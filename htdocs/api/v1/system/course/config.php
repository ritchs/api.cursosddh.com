<?php
  $allowed_methods = ["post", "get", "put", "delete"];
  
  //GET Variables
  $allowed_variables['get'] = ['userid'];
  $required_variables['get'] = [];

  // POST Variables
  $allowed_variables['post'] = ['name'];
  $required_variables['post'] = ['name'];

  // PUT Variables
  $allowed_variables['put'] = [ 'name', 'userid'];
  $required_variables['put'] = ['userid', 'name'];

  // DELETE Variables
  $allowed_variables['delete'] = ['userid'];
  $required_variables['delete'] = ['userid'];