<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\UserCreateType;
use App\Service\MemberService;
use App\Util\ValidationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @author yuu2dev
 * updated 2020.06.03
 */
class MemberController extends AbstractController {
  
  /**     
   * 로그인
   * @Route("/member/login", name="member_login", methods={"GET", "POST"})
   * @Template("/front/member/login.twig")
   * @access public
   * @param AuthenticationUtils $authenticationUtils
   */
  public function login(AuthenticationUtils $authenticationUtils): array {

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
   * @Route("/member/logout", name="member_logout", methods={"GET"}, options={"i18n"=false})
   * @access public
   * @return void
   */
  public function logout(): void {}

  /**
   * 등록
   * @Route("/member/register", name="member_register", methods={"GET", "POST"})
   * @Template("/front/member/register.twig")
   * @access public
   * @param Request $request
   * @param UserPasswordEncoderInterface $userPasswordEncoder
   * @param ValidationUtils $validationUtils
   * @param SecuriyService $securiyService
   * @return array|object
   */
  public function register(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, ValidationUtils $validationUtils, MemberService $memberService): ?array {

    $form = $this->createForm(UserCreateType::class, new User);
    $form->handleRequest($request);
    
    if($form->isSubmitted() && $form->isValid()) {
      
      switch(true) {
        // CSRF Token 검증
        case !$validationUtils->verifyCsrfToken($request): break;
        // Google Recaptcha 검증 
        case !$validationUtils->verifyRecaptcha($request): break;
        default: 
          /** @var User */
          $user = $form->getData();
          $memberService->saveUser($user);

          return $this->redirectToRoute('member_confirm');
      }
    }

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * 등록 확인
   * @access public
   * @Route("/member/confirm", name="member_confirm", methods={"GET"})
   * @Template("/member/confirm.twig")
   */
  public function confirm() {
    return array();
  }
}
