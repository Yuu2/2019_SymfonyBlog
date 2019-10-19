<?php

namespace App\Subscribers;

use App\Repository\CategoryRepository;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CategorySubscriber implements EventSubscriberInterface {

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
      KernelEvents::RESPONSE => 'onApplicationController'
    );
  }

  /**
   * @access public
   * @param ResponseEvent $event
   */
  public function onApplicationController(ResponseEvent $event) {

  }


}