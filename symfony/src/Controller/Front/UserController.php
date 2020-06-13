<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UserService;
use App\Util\ValidationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author yuu2dev
 * updated 2020.06.13
 */
class UserController extends AbstractController {
  
  /**     
   * 로그인
   * @Route("/signin", name="user_signin", methods={"GET", "POST"})
   * @Template("/front/user/signin.twig")
   * @access public
   * @param AuthenticationUtils $authenticationUtils
   * @return array
   */
  public function signin(AuthenticationUtils $authenticationUtils): array {

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
  public function signout(): void {}

  /**
   * 등록
   * @todo 썸네일 업로드
   * @Route("/signup/form", name="user_signup_form", methods={"GET", "POST"})
   * @Template("/front/user/signup_form.twig")
   * @access public
   * @param Request $request
   * @param UserPasswordEncoderInterface $userPasswordEncoder
   * @param ValidationUtils $validationUtils
   * @param UserService $userService
   * @param TranslatorInterface $translator
   * @return array|object
   */
  public function signup(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, ValidationUtils $validationUtils, UserService $userService, TranslatorInterface $translator) {

    $form = $this->createForm(UserType::class, new User);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
         
      switch(true) {
        // CSRF Token 검증
        case !$validationUtils->verifyCsrfToken($request): 
          $this->addFlash('error', $translator->trans('front.user.signup.flash.csrftoken_error'));
        break;
        // Google Recaptcha 검증 
        case $validationUtils->verifyRecaptcha($request): 
          $this->addFlash('error', $translator->trans('front.user.signup.flash.recaptcha_error'));
        break;
        
        default: 
        
          /** @var User */
          $user      = $form->getData();
          $thumbnail = $form->get('thumbnail')->getData();
          $userService->saveThumbnail($thumbnail);
          $userService->saveUser($user);

          return $this->redirectToRoute('user_signup_confirm');
      }
    }

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * 등록 확인
   * @access public
   * @Route("/signup/confirm", name="user_signup_confirm", methods={"GET"})
   * @Template("/user/signup_confirm.twig")
   */
  public function confirm() {
    return array();
  }
}
