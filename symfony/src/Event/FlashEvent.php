<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * @author yuu2dev
 * updated 2020.06.20
 */
class FlashEvent extends Event {

  public const SIGNUP_EMAIL_CONFIRM   = "front.user.signup.flash.email.confirm";

  public const SIGNUP_EMAIL_INVALID   = "front.user.signup.flash.email_invalid";

  public const SIGNUP_EMAIL_VERIFIED  = "front.user.signup.flash.email_verified";

  public const SIGNUP_RECAPTCHAR_FAIL = "front.user.signup.flash.recaptcha.fail";
  
}