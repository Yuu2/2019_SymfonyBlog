<?php

namespace App\Util;

use ReCaptcha\ReCaptcha;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author yuu2
 * updated 2020.01.26
 */
class CustomValidator {

  /**
   * @access public
   */
  public function __construct() {}

  /**
   * Recaptcha 검사
   * @access public
   * @param Request $request
   * @return boolean
   */
  public function checkRecaptcha(Request $request): boolean {
    
    $secretkey = $_SERVER['RECAPTCHA_SECRET'];
  
    if(is_null($secretkey)) return null;

    $recaptcha = new ReCaptcha($secretkey);
    
    return $recaptcha->verify($request->get('g-recaptcha-response'), $request->getClientIp())->isSuccess();
  }
}