<?php

namespace App\Event;

use App\Event\FlashEvent;
use App\Event\RedirectEvent;
use ReCaptcha\ReCaptcha;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author yuu2dev
 * updated 2020.08.01
 */
class RedirectEventSubscriber implements EventSubscriberInterface {

  /**
   * @var AuthorizationCheckerInterface
   */
  private $authorizationChecker;

  /**
   * @var RouterInterface
   */
  private $router;

  /**
   * @var TranslatorInterface
   */
  private $translator;
  
  /**
   * @var TokenStorageInterface
   */
  private $tokenStorage;

  /**
   * @var EventDispatcherInterface
   */
  private $eventDispatcher;

  /**
   * @var bool
   */
  private $kernelResponseFlag = false;

  /**
   * @var string
   */
  private $kernelResponsePath;

  /**
   * @access public
   * @param AuthorizationCheckerInterface $authorizationChecker
   * @param EventDispatcherInterface $eventDispatcher
   * @param RouterInterface $router
   * @param TranslatorInterface $translator
   * @param TokenStorageInterface $tokenStorage
   */
  public function __construct(AuthorizationCheckerInterface $authorizationChecker, EventDispatcherInterface $eventDispatcher, RouterInterface $router, TranslatorInterface $translator, TokenStorageInterface $tokenStorage) {
    $this->authorizationChecker = $authorizationChecker;
    $this->eventDispatcher = $eventDispatcher;
    $this->router = $router;
    $this->translator = $translator;
    $this->tokenStorage = $tokenStorage;
  }

  /**
   * @access public
   * @static
   */
  public static function getSubscribedEvents() {

    return array(
      KernelEvents::RESPONSE => 'onKernelResponse',
      RedirectEvent::REDIRECT_IF_AUTH => 'onRedirectIfAuth',
      RedirectEvent::REDIRECT_IF_NOT_AUTH => 'onRedirectIfNotAuth',
      RedirectEvent::REDIRECT_IF_USER => 'onRedirectIfUser',
      RedirectEvent::REDIRECT_IF_ADMIN => 'onRedirectIfAdmin',
      RedirectEvent::REDIRECT_IF_NOT_ADMIN => 'onRedirectIfNotAdmin',
      RedirectEvent::REDIRECT_IF_INVISIBLE_ARTICLE => 'onRedirectIfInvisibleArticle',
    );
  }

  /**
   * 권한이 있는 대상
   * @access public
   * @param RedirectEvent $event
   * @return void
   */
  public function onRedirectIfAuth(RedirectEvent $event): void {
  
    if ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
        $this->kernelResponseFlag = $kernelResponseFlag;
        $this->kernelResponsePath = $event->getRedirectPath();
    }
  }
  /**
   * 권한이 없는 대상
   * @access public
   * @param RedirectEvent $event
   * @return void
   */
  public function onRedirectIfNotAuth(RedirectEvent $event): void {
  
    if (!$this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
        $this->kernelResponseFlag = $kernelResponseFlag;
        $this->kernelResponsePath = $event->getRedirectPath();
    }
  }

  /**
   * 일반유저 권한이 있는 대상
   * @access public
   * @param RedirectEvent $event
   * @return void
   */
  public function onRedirectIfUser(RedirectEvent $event): void {

    if ($this->authorizationChecker->isGranted('ROLE_USER')) {
        $this->kernelResponseFlag = $kernelResponseFlag;
        $this->kernelResponsePath = $event->getRedirectPath();
    }
  }

  /**
   * 관리자 권한이 있는 대상
   * @access public
   * @param RedirectEvent $event
   * @return void
   */
  public function onRedirectIfAdmin(RedirectEvent $event): void {

    if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
        $this->kernelResponseFlag = $kernelResponseFlag;
        $this->kernelResponsePath = $event->getRedirectPath();
    }
  }

  /**
   * 관리자 권한이 없는 대상
   * @access public
   * @param RedirectEvent $event
   * @return void
   */
  public function onRedirectIfNotAdmin(RedirectEvent $event): void {

    if (!$this->authorizationChecker->isGranted('ROLE_ADMIN')) {
        $this->kernelResponseFlag = $kernelResponseFlag;
        $this->kernelResponsePath = $event->getRedirectPath();
    }
  }

  /**
   * 게시글을 조회 할 수 없을 경우
   * @access public
   * @param RedirectEvent $event
   * @return void
   */
  public function onRedirectIfInvisibleArticle(RedirectEvent $event): void {

    $kernelResponseFlag = is_null($event->getArticle());

    if ($kernelResponseFlag) {
      
      $this->kernelResponseFlag = $kernelResponseFlag;
      $this->kernelResponsePath = $event->getRedirectPath();
    }
  }

  /**
   * @access public
   * @param ResponseEvent $event
   * @return void
   */
  public function onKernelResponse(ResponseEvent $event): void {
    
    $kernelResponseFlag = $this->kernelResponseFlag;
    $kernelResponsePath = $this->kernelResponsePath;
    
    if ($kernelResponseFlag) {

      $redirectRouter   = $this->router->generate($kernelResponsePath);
      
      $redirectResponse = new RedirectResponse($redirectRouter);

      $event->setResponse($redirectResponse);
    }
  }
}