<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Event\FlashEvent;
use App\Event\RedirectEvent;
use App\Form\UserType;
use App\Security\Authenticator;
use App\Security\EmailVerifier;
use App\Service\UserService;
use App\Util\RecaptchaUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @author yuu2dev
 * updated 2020.08.01
 */
class UserController extends AbstractController {

  /**     
   * 로그인
   * @todo 이벤트 리스너
   * @Route("/signin", name="user_signin", methods={"GET", "POST"})
   * @Template("/front/user/signin.twig")
   * @access public
   * @param AuthenticationUtils $authenticationUtils
   * @param EventDispatcherInterface $eventDispatcher
   * @return array|object
   */
  public function signIn(AuthenticationUtils $authenticationUtils, EventDispatcherInterface $eventDispatcher) {
    
    $eventDispatcher->dispatch(RedirectEvent::REDIRECT_IF_AUTH, new RedirectEvent);

    $lastAuthenticationError = $authenticationUtils->getLastAuthenticationError();

    $lastUsername = $authenticationUtils->getLastUsername();
    
    return [
      'last_username' => $lastUsername, 
      'last_authentication_error' => $lastAuthenticationError
    ];
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
   * @param EmailVerifier $emailVerifier
   * @param EventDispatcherInterface $eventDispatcher
   * @param GuardAuthenticatorHandler $guardAuthenticatorHandler
   * @param Request $request
   * @param RecaptchaUtils $recaptchaUtils
   * @param TranslatorInterface $translator
   * @param UserService $userService
   * @return array|object
   */
  public function signUpForm(
    Authenticator $authenticator, 
    EmailVerifier $emailVerifier, 
    EventDispatcherInterface $eventDispatcher, 
    GuardAuthenticatorHandler $guardAuthenticatorHandler, 
    Request $request, 
    RecaptchaUtils $recaptchaUtils, 
    TranslatorInterface $translator, 
    UserService $userService
  ) {
    
    $eventDispatcher->dispatch(RedirectEvent::REDIRECT_IF_AUTH,  new RedirectEvent);
    
    $form = $this->createForm(UserType::class, new User);
    $form->handleRequest($request);

    switch(true) {

      /* FormType 검사 */
      case !($form->isSubmitted() && $form->isValid()): break;
      
      /* Google Recaptcha 검사 */ 
      case !$recaptchaUtils->verifyRecaptcha($request): 
        $eventDispatcher->dispatch(FlashEvent::SIGNUP_RECAPTCHAR_FAIL); break;
      
      default:
        
        /** @var User */
        $user          = $form->getData();
        $thumbnail     = $form->get('thumbnail')->getData();
        $thumbnail_src = $userService->saveThumbnail($thumbnail);
          
        $user->setThumbnail($thumbnail_src);
        $userService->saveUser($user);

        /** 메일 인증 */
        $email = $emailVerifier->setVerifyEmail($user->getEmail(), $translator->trans('front.user.signup.sender'));
        $emailVerifier->sendEmailConfirmation('user_signup_verify',  $user, $email);
        
        $guardAuthenticatorHandler->authenticateUserAndHandleSuccess($user, $request, $authenticator, 'main');

        $eventDispatcher->dispatch(FlashEvent::SIGNUP_EMAIL_CONFIRM);

        return $this->redirectToRoute('blank');
    }

    return [
      'form' => $form->createView()
    ];
  }

  /**
   * 이메일 중복검사
   * @Route("/signup/dupcheck", name="user_signup_dupcheck", methods={"GET", "POST"})
   * @access public
   * @param Request $request
   * @param UserService $userService
   * @return JsonResponse
   */
  public function signUpCheckEmail(Request $request, UserService $userService): JsonResponse {

    $_email = $request->request->get('_email');

    $jsonResponse = new JsonResponse();

    if (is_null($_email)) {
      $jsonResponse->setStatusCode(Response::HTTP_BAD_REQUEST);
    } else {
      $isDuplicated = $userService->isDuplicatedEmail($_email);
      $jsonResponse->setStatusCode(Response::HTTP_OK);
      $jsonResponse->setData([
        'isDuplicated' => $isDuplicated
      ]);
    }
    return $jsonResponse;
  }

  /**
   * 메일 인증
   * @todo 이벤트 리스너
   * @access public
   * @param EmailVerifier $emailVerifier
   * @param EventDispatcherInterface $eventDispatcher
   * @param Request $request
   * @return
   * @Route("/signup/verify", name="user_signup_verify", methods={"GET"})
   */
  public function signUpVerifyEmail(EmailVerifier $emailVerifier, EventDispatcherInterface $eventDispatcher, Request $request) {
    
    try {
      
      $emailVerifier->handleEmailConfirmation($request, $this->getUser());
      
      $eventDispatcher->dispatch(FlashEvent::SIGNUP_EMAIL_VERIFIED);

    } catch (VerifyEmailExceptionInterface $verifyEmailException) {
      
      $eventDispatcher->dispatch(FlashEvent::SIGNUP_EMAIL_INVALID);
    }

    return $this->redirectToRoute('blank');
  }
}
