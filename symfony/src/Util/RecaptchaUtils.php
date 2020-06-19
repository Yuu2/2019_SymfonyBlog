<?php

namespace App\Util;

use ReCaptcha\ReCaptcha;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author yuu2dev
 * updated 2020.06.19
 */
class RecaptchaUtils {

  /**
   * Recaptcha 검사
   * @access public
   * @static
   * @param Request $request
   * @return boolean
   */
  public static function verifyRecaptcha(Request $request): bool {
    
    $secretkey = $_SERVER['RECAPTCHA_SECRET'];
  
    /** @todo 커스텀 예외 작성 */
    if(is_null($secretkey)) throw new \Exception(); 

    $recaptcha = new ReCaptcha($secretkey);
    
    return $recaptcha->verify($request->get('g-recaptcha-response'), $request->getClientIp())->isSuccess();
  }
}