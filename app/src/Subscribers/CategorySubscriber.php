<?php

namespace App\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CategorySubscriber implements EventSubscriberInterface {

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
  public function OnServeCategory() {
    
  }


}