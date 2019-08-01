<?php

namespace App\Util;

class Validator {

  /**
   * @access public
   * @static 
   * @return boolean
   */
  function isNum($num) {
    
    if(empty($num)) {
      return false;
    }
    
    if(!is_numeric($num)) {
      return false;
    }
  
    return true;
  }
} 




