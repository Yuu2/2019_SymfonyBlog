<?php

namespace App\Event;

use App\Event\FlashEvent;
use App\Event\SecurityEvent;
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
 * updated 2020.06.20
 */
class SecurityEventSubscriber implements EventSubscriberInterface {

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
  private $kernelResponseUrl;

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
      SecurityEvent::REDIRECT_IF_ROLE_USER => 'onRedirectIfRoleUser'
    );
  }
  
  /**
   * @access public
   * @return void
   */
  public function onRedirectIfRoleUser(): void {

    if ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
      $this->kernelResponseFlag = true;
      $this->kernelResponseUrl  = 'home';
    }
  }

  /**
   * @access public
   * @param ResponseEvent $event
   * @return void
   */
  public function onKernelResponse(ResponseEvent $event): void {

    if ($this->kernelResponseFlag) {
      $event->setResponse(new RedirectResponse($this->router->generate($this->kernelResponseUrl)));
    }
  }
}