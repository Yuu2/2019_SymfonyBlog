<?php

namespace App\Security;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

/**
 * @author yuu2dev
 * updated 2020.06.17
 */
class EmailVerifier {

  /**
   * @var VerifyEmailHelperInterface
   */
  private $verifyEmailHelper;
  
  /**
   * @var MailerInterface
   */
  private $mailer;
  
  /**
   * @var EntityManagerInterface
   */
  private $entityManager;

  /**
   * @access public
   * @param VerifyEmailHelperInterface $verifyEmailHelper
   * @param MailerInterface $mailer
   * @param EntityManagerInterface $entityManager
   */
  public function __construct(VerifyEmailHelperInterface $verifyEmailHelper, MailerInterface $mailer, EntityManagerInterface $entityManager) {
    
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
}
