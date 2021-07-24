<?php
  $allowed_methods = ["post", "get", "put", "delete"];
  
  //GET Variables
  $allowed_variables['get'] = ['userid'];
  $required_variables['get'] = [];
  
  // POST Variables
  $allowed_variables['post'] = [ 'name','date','id_course','id_place','constancy'];
  $required_variables['post'] = [ 'name','date','id_course','id_place','constancy'];

  // PUT Variables
  $allowed_variables['put'] = [ 'userid','name','date','id_course', 'id_place','constancy'];
  $required_variables['put'] = ['userid','name','date','id_course', 'id_place','constancy'];

  // DELETE Variables
  $allowed_variables['delete'] = ['userid'];
  $required_variables['delete'] = ['userid'];