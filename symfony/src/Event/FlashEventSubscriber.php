<?php

namespace App\Event;

use App\Event\FlashEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class FlashEventSubscriber implements EventSubscriberInterface {

  /**
   * @var FlashBagInterface
   */
  private $flashBag;
  
  /**
   * @var RouterInterface
   */
  private $router;

  /**
   * @var TranslatorInterface
   */
  private $translator;

  /**
   * @access public
   * @param FlashBagInterface $flashBag
   * @param RouterInterface $router
   * @param TranslatorInterface $translator
   */
  public function __construct(FlashBagInterface $flashBag, RouterInterface $router, TranslatorInterface $translator) {
    $this->flashBag = $flashBag;
    $this->router = $router;
    $this->translator = $translator;
  }

  /**
   * @access public
   * @static
   */
  public static function getSubscribedEvents() {
    
    return array(
      
      FlashEvent::SIGNUP_EMAIL_CONFIRM => 'onSignUpConfirmEmail',
      FlashEvent::SIGNUP_EMAIL_INVALID => 'onSignUpInvalidEmail',
      FlashEvent::SIGNUP_EMAIL_VERIFIED => 'onSignUpVerifiedEmail',
      FlashEvent::SIGNUP_RECAPTCHAR_FAILED => 'onSignUpRecaptchaFailed',

      FlashEvent::BLOG_ARTICLE_COMMENT_DEL_SUCCESS => 'onBlogArticleCommentDelSuccess',
      FlashEvent::BLOG_ARTICLE_COMMENT_DEL_FAILED => 'onBlogArticleCommentDelFailed',
      FlashEvent::BLOG_ARTICLE_COMMENT_DEL_PASSWORD_INVALID => 'onBlogArticleCommentDelPasswordInvalid',
    );
  }

  /**
   * 메일인증 전송 안내
   * @access public
   */
  public function onSignUpConfirmEmail() {
   $this->flashBag->add('info', $this->translator->trans(FlashEvent::SIGNUP_EMAIL_CONFIRM));
  }

  /**
   * 메일인증 성공 안내
   * @access public
   */
  public function onSignUpVerifiedEmail() {
    $this->flashBag->add('success', $this->translator->trans(FlashEvent::SIGNUP_EMAIL_VERIFIED));
  }

  /**
   * 메일인증 실패 안내
   * @access public
   */
  public function onSignUpInvalidEmail() {
    $this->flashBag->add('danger', $this->translator->trans(FlashEvent::SIGNUP_EMAIL_INVALID));
  }
  
  /**
   * 멤버등록 G-Recaptcha 실패
   * @access public
   * @return void
   */
  public function onSignUpFailedRecaptcha(): void {  
    $this->flashBag->add('danger', $this->translator->trans(FlashEvent::SIGNUP_RECAPTCHAR_FAILED)); 
  }

  /**
   * 게시글 댓글 삭제 성공
   * @access public
   * @return void
   */
  public function onBlogArticleCommentDelSuccess(): void {  
    $this->flashBag->add('success', $this->translator->trans(FlashEvent::BLOG_ARTICLE_COMMENT_DEL_SUCCESS)); 
  }

  /**
   * 게시글 댓글 작성 실패
   * @access public
   * @return void
   */
  public function onBlogArticleCommentDelFailed(): void {  
    $this->flashBag->add('danger', $this->translator->trans(FlashEvent::BLOG_ARTICLE_COMMENT_DEL_FAILED)); 
  }

  /**
   * 게시글 댓글 부정확한 암호
   * @access public
   * @return void
   */
  public function onBlogArticleCommentDelPasswordInvalid(): void {  
    $this->flashBag->add('danger', $this->translator->trans(FlashEvent::BLOG_ARTICLE_COMMENT_DEL_PASSWORD_INVALID)); 
  }
}