<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Util\CustomValidator;
use App\Form\UserCreateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
/**
 * @author yuu2
 * updated 2020.01.26
 */
class SecurityController extends AbstractController {
  
  /**     
   * 로그인
   * @Route("/login", name="sec_login", methods={"GET", "POST"})
   * @Template("/security/login.twig")
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
   * @Route("/logout", name="sec_logout", methods={"GET"}, options={"i18n"=false})
   * @access public
   * @return void
   */
  public function logout(): void {}

  /**
   * 등록
   * @Route("/register", name="sec_register", methods={"GET", "POST"})
   * @Template("/security/register.twig")
   * @access public
   * @param Request $request
   * @param UserPasswordEncoderInterface $userPasswordEncoder
   * @return array
   */
  public function register(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, CustomValidator $customValidator): array {

    $form = $this->createForm(
      UserCreateType::class, new User, array(
        'attr' => array('novalidate' => 'novalidate')
    ));

    $form->handleRequest($request);
  
    switch($form->isSubmitted() && $form->isValid()) {

      // CSRF 토큰 검증
      case !$customValidator->verifyCsrfToken($request):
       
      break;

      // Recaptcha 검증 
      case !$customValidator->verifyRecaptcha($request):
      
      break;

      default: 
        
    }

    return array(
      'form' => $form->createView()
    );
  }
}
