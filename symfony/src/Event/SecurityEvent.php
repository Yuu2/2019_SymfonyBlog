<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
/**
 * @author yuu2dev
 * updated 2020.06.20
 */
class SecurityEvent extends Event {

  public const REDIRECT_IF_ROLE_USER = "security.redirect.if.role_user";
  
  /**
   * @var Request $request
   */
  private $request;

  /**
   * @access public
   * @return Request
   */
  public function getRequest(): Request {

    return $this->request;
  }

  /**
   * @access public
   * @param Request $request
   */
  public function setRequest(Request $request) {

    $this->request = $request;
    
    return $this;
  }
}