<?php

namespace App\Util;

use ReCaptcha\ReCaptcha;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * @author yuu2dev
 * updated 2020.06.10
 */
class ValidationUtils {

  /**
   * @var CsrfTokenManagerInterface
   */
  private $csrfTokenManager;

  /**
   * @access public
   */
  public function __construct(CsrfTokenManagerInterface $csrfTokenManager) {
    $this->csrfTokenManager = $csrfTokenManager;
  }

  /**
   * CSRF Token 검사
   * @access public
   * @static
   * @param Request $request
   * @return bool
   */
  public function verifyCsrfToken(Request $request): bool {
    
    $token = $request->request->get('_csrf_token');

    if(is_null($token)) return false; 

    return $this->csrfTokenManager->getToken($token) ? true : false;
  }

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

  /**
   * 문자열 초과 길이 검사
   * @access public
   * @param string $str
   * @param int $limit
   * @return bool
   */
  public static function isOverLength(string $str, int $limit): bool {
    return mb_strlen($str) > $lmit;
  }
    /**
   * 문자열 미만 길이 검사
   * @access public
   * @param string $str
   * @param int $limit
   * @return bool
   */
  public static function isLessLength(string $str, int $limit): bool {
    return mb_strlen($str) < $lmit;
  }
}