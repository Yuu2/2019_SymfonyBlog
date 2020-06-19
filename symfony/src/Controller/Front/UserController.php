<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\UserType;
use App\Security\Authenticator;
use App\Security\EmailVerifier;
use App\Service\UserService;
use App\Util\RecaptchaUtils;
use App\Util\EmailUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @author yuu2dev
 * updated 2020.06.19
 */
class UserController extends AbstractController {

  /**     
   * 로그인
   * @todo 이벤트 리스너
   * @Route("/signin", name="user_signin", methods={"GET", "POST"})
   * @Template("/front/user/signin.twig")
   * @access public
   * @param AuthenticationUtils $authenticationUtils
   * @return array|object
   */
  public function signIn(AuthenticationUtils $authenticationUtils) {
    
    if ($this->getUser()) { 
      return $this->redirectToRoute($route); 
    }

    $error = $authenticationUtils->getLastAuthenticationError();

    $lastUsername = $authenticationUtils->getLastUsername();
    
    return array (

      'last_username' => $lastUsername, 
      'error' => $error
    );
  }

  /**
   * 로그아웃
   * @Route("/signout", name="user_signout", methods={"GET"}, options={"i18n"=false})
   * @access public
   * @return void
   */
  public function signOut(): void {}

  /**
   * 등록
   * @todo 이벤트 리스너
   * @Route("/signup", name="user_signup", methods={"GET", "POST"})
   * @Template("/front/user/signup.twig")
   * @access public
   * @param Authenticator $authenticator
   * @param EmailUtils $emailUtils
   * @param EmailVerifier $emailVerifier
   * @param GuardAuthenticatorHandler $guardAuthenticatorHandler
   * @param Request $request
   * @param RecaptchaUtils $recaptchaUtils
   * @param UserService $userService
   * @param TranslatorInterface $translator
   * @return array|object
   */
  public function signUpForm(Authenticator $authenticator, EmailUtils $emailUtils, EmailVerifier $emailVerifier,  GuardAuthenticatorHandler $guardAuthenticatorHandler,  Request $request, RecaptchaUtils $recaptchaUtils, UserService $userService, TranslatorInterface $translator) {

    if ($this->getUser()) {  
      return $this->redirectToRoute($route);
    }
    
    $form = $this->createForm(UserType::class, new User);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
      
      if($recaptchaUtils->verifyRecaptcha($request)) {

        /** @var User */
        $user          = $form->getData();
        $thumbnail     = $form->get('thumbnail')->getData();
        $thumbnail_src = $userService->saveThumbnail($thumbnail);
        
        $user->setThumbnail($thumbnail_src);
        $userService->saveUser($user);

        /** 메일 인증 */
        $email = $emailUtils->setVerifyEmail($user->getEmail(), $translator->trans('front.user.signup.sender'));
        $emailVerifier->sendEmailConfirmation('user_signup_verify',  $user, $email);

        $this->addFlash('info', $translator->trans('front.user.signup.flash.email_confirm'));
        return $this->redirectToRoute('blank');
        
      } else {

        $this->addFlash('danger', $translator->trans('front.user.signup.flash.recaptcha_invalid'));
      }
    }

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * 이메일 중복검사
   * @access public
   * @Route("/signup/dupcheck", name="user_signup_dupcheck", methods={"GET"})
   */
  public function signUpCheckEmail() {

    return new JsonResponse(null);
  }

  /**
   * 메일 인증
   * @todo 이벤트 리스너
   * @access public
   * @param EmailVerifier $emailVerifier
   * @param Request $request
   * @param TranslatorInterface $translator
   * @param object
   * @Route("/signup/verify", name="user_signup_verify", methods={"GET"})
   */
  public function signUpVerifyEmail(EmailVerifier $emailVerifier, Request $request, TranslatorInterface $translator): object {
    
    try {
      
      $emailVerifier->handleEmailConfirmation($request, $this->getUser());
      
    } catch (VerifyEmailExceptionInterface $verifyEmailException) {
      
      $this->addFlash('danger', $translator->trans('front.user.signup.flash.email_invalid'));
      
      return $this->redirectToRoute('blank');
    }
    
    $this->addFlash('success', $translator->trans('front.user.signup.flash.email_verified'));

    return $this->redirectToRoute('blank');
  }
}
