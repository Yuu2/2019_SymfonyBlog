<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UserService;
use App\Util\ValidationUtils;
use App\Security\EmailVerifier;
use App\Security\Authenticator;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Address;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @author yuu2dev
 * updated 2020.06.17
 */
class UserController extends AbstractController {
  
  /**
   * @var EmailVerifier $emailVerifier
   */
  private $emailVerifier;

  /**
   * @access public
   * @param EmailVerifier $emailVerifier
   */
  public function __construct(EmailVerifier $emailVerifier) {

    $this->emailVerifier = $emailVerifier;
  }

  /**     
   * 로그인
   * @Route("/signin", name="user_signin", methods={"GET", "POST"})
   * @Template("/front/user/signin.twig")
   * @access public
   * @param AuthenticationUtils $authenticationUtils
   * @return array
   */
  public function signIn(AuthenticationUtils $authenticationUtils): array {

    if($this->getUser()) return $this->redirectToRoute('blog_index');

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
   * @todo 중복코드 리팩토링
   * @Route("/signup/form", name="user_signup_form", methods={"GET", "POST"})
   * @Template("/front/user/signup_form.twig")
   * @access public
   * @param Authenticator $authenticator
   * @param GuardAuthenticatorHandler $guardAuthenticatorHandler
   * @param Request $request
   * @param ValidationUtils $validationUtils
   * @param UserService $userService
   * @param TranslatorInterface $translator
   * @return array|object
   */
  public function signUpForm(Authenticator $authenticator, GuardAuthenticatorHandler $guardAuthenticatorHandler,  Request $request, ValidationUtils $validationUtils, UserService $userService, TranslatorInterface $translator) {

    $form = $this->createForm(UserType::class, new User);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
      
      if($validationUtils->verifyRecaptcha($request)) {

        /** @var User */
        $user          = $form->getData();
        $thumbnail     = $form->get('thumbnail')->getData();
        $thumbnail_src = $userService->saveThumbnail($thumbnail);
         
        $user->setThumbnail($thumbnail_src);

        $userService->saveUser($user);

        /* 

          $this->emailVerifier->sendEmailConfirmation('user_signup_verify_email', 
            $user, 
            (new TemplatedEmail())
              ->from(new Address($_SERVER['APP_ADMIN_EMAIL'], $_SERVER['APP_ADMIN_NAME']))
              ->to($user->getEmail())
              ->subject($translator->trans('front.user.signup.verification'))
              ->htmlTemplate('front/user/signup_verify_email.twig')
          );
        */

        return $guardAuthenticatorHandler->authenticateUserAndHandleSuccess($user, $request, $authenticator, 'main');
      
      } else {

        $this->addFlash('danger', $translator->trans('front.user.signup.flash.recaptcha_error'));
      }
    }

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * 이메일 중복검사
   * @access public
   * @Route("/signup/check_email", name="user_signup_check_email", methods={"GET"})
   */
  public function signUpCheckEmail() {

    return new JsonResponse(null);
  }

  /**
   * 이메일 인증
   * @access public
   * @param Request $request
   * @param TranslatorInterface $translator
   * @param object
   * @Route("/signup/verify_email", name="user_signup_verify_email", methods={"GET"})
   */
  public function signUpVerifyEmail(Request $request, TranslatorInterface $translator): object {
    
    try {
      
      $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
      
    } catch (VerifyEmailExceptionInterface $verifyEmailException) {
      
      $this->addFlash('danger', $translator->trans('front.user.signup.flash.email_invalid_error'));
      
      return $this->redirectToRoute('home');
    }

    $this->addFlash('success', $translator->trans('front.user.signup.flash.email_verified'));

    return $this->redirectToRoute('home');
  }
}
