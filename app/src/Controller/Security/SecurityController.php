<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * updated 2019.12.31
 * @author Yuu2
 */
class SecurityController extends AbstractController {
  
  /**     
   * 로그인
   * @access public
   * @return array
   * @Route("/login", name="sec_login", methods={"GET", "POST"})
   * @Template("/security/login.twig")
   */
  public function login(AuthenticationUtils $authenticationUtils): ?array {

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
   * @access public
   * @return void
   * @Route("/logout", name="sec_logout", methods={"GET"})
   */
  public function logout(): void {}

  /**
   * 등록
   * @access public
   * @param Request $request
   * @param UserPasswordEncoderInterface $userPasswordEncoder
   * @return array
   * @Route("/register", name="sec_register", methods={"GET", "POST"})
   * @Template("/security/register.twig")
   */
  public function register(Request $request, UserPasswordEncoderInterface $userPasswordEncoder): ?array {

    $user = new User;
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
      dd('Submitted!');
    }

    return array(
      'form' => $form->createView()
    );
  }
}
