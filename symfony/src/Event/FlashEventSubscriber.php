<?php

namespace App\Event;

use App\Event\FlashEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

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
      
      FlashEvent::SIGNUP_EMAIL_CONFIRM       => 'onSignUpConfirmEmail',
      FlashEvent::SIGNUP_EMAIL_INVALID       => 'onSignUpInvalidEmail',
      FlashEvent::SIGNUP_EMAIL_VERIFIED      => 'onSignUpVerifiedEmail',
      FlashEvent::SIGNUP_RECAPTCHAR_FAIL     => 'onSignUpFailRecaptcha',
      FlashEvent::BLOG_ARTICLE_WRITE_FAIL    => 'onBlogArticleFailWrtie',
      FlashEvent::BLOG_ARTICLE_WRITE_SUCCESS => 'onBlogArticleSuccessWrtie',
    );
  }

  /**
   * @access public
   */
  public function onSignUpConfirmEmail() {
   $this->flashBag->add('info', $this->translator->trans('front.user.signup.flash.email_confirm'));
  }

  /**
   * @access public
   */
  public function onSignUpVerifiedEmail() {
    $this->flashBag->add('success', $this->translator->trans('front.user.signup.flash.email_verified'));
  }

  /**
   * @access public
   */
  public function onSignUpInvalidEmail() {
    $this->flashBag->add('danger', $this->translator->trans('front.user.signup.flash.email_invalid'));
  }
  
  /**
   * @access public
   * @return void
   */
  public function onSignUpFailRecaptcha(): void {  
    $this->flashBag->add('danger', $this->translator->trans('front.user.signup.flash.recaptcha_fail')); 
  }
  
  /**
   * @access public
   * @return void
   */
  public function onBlogArticleFailWrtie(): void {  
    $this->flashBag->add('danger', $this->translator->trans('front.blog.article.wrtie.fail')); 
  }

  /**
   * @access public
   * @return void
   */
  public function onBlogArticleSuccessWrtie(): void {  
    $this->flashBag->add('success', $this->translator->trans('front.blog.article.wrtie.success')); 
  }

}