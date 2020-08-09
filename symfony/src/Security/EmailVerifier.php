<?php

namespace App\Security;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

/**
 * @author yuu2dev
 * updated 2020.06.17
 */
class EmailVerifier {

  /**
   * @var EntityManagerInterface
   */
  private $entityManager;
  
  /**
   * @var MailerInterface
   */
  private $mailer;

  /**
   * @var VerifyEmailHelperInterface
   */
  private $verifyEmailHelper;

  /**
   * @access public
   * @param EntityManagerInterface $entityManager
   * @param MailerInterface $mailer
   * @param VerifyEmailHelperInterface $verifyEmailHelper
   */
  public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailer, VerifyEmailHelperInterface $verifyEmailHelper) {
    
    $this->verifyEmailHelper = $verifyEmailHelper;
    $this->mailer = $mailer;
    $this->entityManager = $entityManager;
  }

  /**
   * @access public
   * @param string verfiyEmailRouteName
   * @param UserInterface $user
   * @param TemplatedEmail $templatedEmail
   * @return void
   */
  public function sendEmailConfirmation(string $verifyEmailRouteName, UserInterface $user, TemplatedEmail $templatedEmail): void {
    
    $signatureComponents = $this->verifyEmailHelper->generateSignature(
      $verifyEmailRouteName,
      $user->getId(),
      $user->getEmail()
    );

    $context = $templatedEmail->getContext();
    $context['signedUrl'] = $signatureComponents->getSignedUrl();
    $context['expiresAt'] = $signatureComponents->getExpiresAt();

    $templatedEmail->context($context);

    $this->mailer->send($templatedEmail);
  }

  /**
   * @access public
   * @param Request $request
   * @param UserInterface $user
   * @throws VerifyEmailExceptionInterface
   */
  public function handleEmailConfirmation(Request $request, UserInterface $user): void {
    
    $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());

    $user->setIsVerified(true);

    $this->entityManager->persist($user);
    $this->entityManager->flush();
  }

  /**
   * 메일 인증 템플릿
   * @access public
   * @param string $to
   * @return TemplatedEmail
   */
  public function setVerifyEmail($to, $subject): TemplatedEmail {

    return (new TemplatedEmail())
      ->from(new Address($_SERVER['OWNER_EMAIL'], $_SERVER['OWNER']))
      ->to($to)
      ->subject($subject)
      ->htmlTemplate('email/signup.twig');
  }
}
