<?php

namespace App\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EventDispatcher\Events\AsideEvent;


class AsideSubscriber implements EventSubscriberInterface {

  /**
   * @access public
   */
  public function __construct() {}

  /**
   * @access public
   * @static
   */
  public static function getSubscribedEvents() {

    return array(

    );
  }

  /**
   * @access public
   */
  public function serve(AsideEvent $event) {
    
  }


}