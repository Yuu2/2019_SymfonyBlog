<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
/**
 * @author yuu2dev
 * updated 2020.08.01
 */
class RedirectEvent extends Event {

  public const REDIRECT                      = "redirect";
  public const REDIRECT_IF_AUTH              = "redirect.if.authenticated";
  public const REDIRECT_IF_NOT_AUTH          = "redirect.if.not.authenticated";
  public const REDIRECT_IF_USER              = "redirect.if.role_user";
  public const REDIRECT_IF_ADMIN             = "redirect.if.role_admin";
  public const REDIRECT_IF_NOT_ADMIN         = "redirect.if.not.role_admin";
  
  /**
   * @var string
   */
  private $redirect_path = 'blog_article_index';

  /**
   * @var Request $request
   */
  private $request;

  /**
   * @access public
   * @param string $redirect_path
   */
  public function __construct(?string $redirect_path = null) {
    is_null($redirect_path) ? $this->redirect_path : $this->redirect_path = $redirect_path;
  }

  /**
   * @access public
   * @return string
   */
  public function getRedirectPath(): ?string {
    return $this->redirect_path;
  }

  /**
   * @access public
   * @return self
   */
  public function setRedirectPath(?string $redirect_path): self {

    $this->redirect_path = $redirect_path;

    return $this;
  }

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
   * @return self
   */
  public function setRequest(Request $request): self {

    $this->request = $request;
    
    return $this;
  }
}