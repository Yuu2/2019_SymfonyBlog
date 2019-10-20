<?php

namespace App\Subscribers;

use App\Repository\CategoryRepository;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @author Yuu2
 */
class ApplicationSubscriber implements EventSubscriberInterface {

  /**
   * @var CategoryRepository
   */
  private $categoryRepository;

  /**
   * @access public
   */
  public function __construct(
    CategoryRepository $categoryRepository
  ) {
    $this->categoryRepository = $categoryRepository;  
  }

  /**
   * @access public
   * @static
   */
  public static function getSubscribedEvents() {

    return array(
      KernelEvents::RESPONSE => 'onHeader'
    );
  }

  /**
   * 템플릿헤더 리스폰스 전처리
   * @access public
   * @param ResponseEvent $event
   */
  public function onHeader(ResponseEvent $event) {

  }
}