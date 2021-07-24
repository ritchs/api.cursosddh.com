<?php

spl_autoload_register('autoloader');

function autoloader($classname) {
  $classname = strtolower($classname);
  $classname = str_replace('_', '-', $classname);
  include_once("../_system/$classname.php");
}