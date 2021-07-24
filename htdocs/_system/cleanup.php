<?php

  class Cleanup {

    function rewalkCleanup(&$item, $key) {
      $item = $this -> cleanvar($item);
    }

    function cleanupArray($dirtyArray) {
      @array_walk_recursive($dirtyArray, 'Cleanup::rewalkCleanup');
      return $dirtyArray;
    }

    function cleanvar($string) {
      if (is_array($string)) {
        return $this -> cleanupArray($string);
      }

      $cleantable=array
      ( 
        "<br />" => "",
        "'" => "&#039;",  
        "<" => "&lt;",
        ">" => "&gt;",
        "%" => "&#37;",
        "\"" => "&quot;",
        "(" => "&#40;",
        ")" => "&#41;",
        "&lrm;" => "",
        "&#8206;" => "",
        "&#x200e;" => "",
        "&rlm;" => "",
        "&#8207;" => "",
        "%E2%80%8E" => ""
      );

      $string=trim($string);
      $string=strtr($string, $cleantable);
      
      return($string);
    }
  }