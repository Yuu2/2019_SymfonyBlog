<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * updated 2019.12.30
 * @author Yuu2
 */
class SecurityController extends AbstractController {

    /**     
     * 로그인
     * @access public
     * @Route("/login", name="sec_login", methods={"GET", "POST"})
     * @Template("/security/login.twig")
     */
    public function login(AuthenticationUtils $authenticationUtils) {

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
     * @Route("/logout", name="sec_logout", methods={"GET"})
     */
    public function logout() {
      
    }
}
