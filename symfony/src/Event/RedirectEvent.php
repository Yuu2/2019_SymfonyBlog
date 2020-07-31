<?php

namespace App\Event;

use App\Entity\Article;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
/**
 * @author yuu2dev
 * updated 2020.08.01
 */
class RedirectEvent extends Event {

  public const REDIRECT_IF_AUTH              = "redirect.redirect.if.authenticated";
  public const REDIRECT_IF_NOT_AUTH          = "redirect.redirect.if.not.authenticated";
  public const REDIRECT_IF_USER              = "redirect.redirect.if.role_user";
  public const REDIRECT_IF_ADMIN             = "redirect.redirect.if.role_admin";
  public const REDIRECT_IF_NOT_ADMIN         = "redirect.redirect.if.not.role_admin";
  public const REDIRECT_IF_INVISIBLE_ARTICLE = "redirect.redirect.if.invisible.article";
  
  /**
   * @var string
   */
  private $redirect_path;

  /**
   * @var Article
   */
  private $article;

  /**
   * @var Request $request
   */
  private $request;

  /**
   * @access public
   * @param string $redirect_path
   */
  public function __construct(?string $redirect_path = null) {

    is_null($redirect_path) ? $this->redirect_path = 'home' : $this->redirect_path = $redirect_path;

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
   */
  public function getArticle(): ?Article {

    return $this->article;
  }

  /**
   * @access public
   * @param Article $article
   * @return self
   */
  public function setArticle(?Article $article): self {

    $this->article = $article;

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