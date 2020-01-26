<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Util\CustomValidator;
use App\Form\UserRegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
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
   * @return array
   */
  public function login(AuthenticationUtils $authenticationUtils): array {

    if($this->getUser()) return $this->redirectToRoute('home');

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
   * @param CustomValidator $customValidator
   * @return array
   */
  public function register(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, CustomValidator $customValidator): array {

    $form = $this->createForm(
      UserRegisterType::class, new User, array(
        'attr' => array('novalidate' => 'novalidate')
    ));
    $form->handleRequest($request);
    
    $recaptcha = true;
    $csrfToken = $request->get('_token'); 
    
    if($form->isSubmitted() && $form->isValid() && $this->isCsrfTokenValid('user', $csrfToken)) {
      
      $checkRecaptcha = $customValidator->checkRecaptcha($request);
      
      if($checkRecaptcha) {

        // TODO: 회원가입 서비스 로직 작성.
      } else {
        $recaptcha = false;
      }
    }

    return array(
      'form' => $form->createView(),
      'recaptcha' => $recaptcha
    );
  }
}
