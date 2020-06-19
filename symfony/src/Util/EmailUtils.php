<?php

namespace App\Util;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

/**
 * @author yuu2dev
 * updated 2020.06.19
 */
class EmailUtils {

  /**
   * 메일 인증 템플릿
   * @access public
   * @param string $to
   * @return TemplatedEmail
   */
  public function setVerifyEmail($to, $subject): TemplatedEmail {

    return (new TemplatedEmail())
      ->from(new Address($_SERVER['APP_HOST_EMAIL'], $_SERVER['APP_HOST']))
      ->to($to)
      ->subject($subject)
      ->htmlTemplate('email/signup.twig');
  }
}