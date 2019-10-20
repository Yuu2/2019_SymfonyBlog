<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use ReCaptcha\ReCaptcha;

/**
 * 2019.10.20
 * @author Yuu2
 */
class AccountController extends AbstractController implements ApplicationController {

    /**     
     * 로그인
     * @access public
     * @Route("/account/signin", name="account_signin", methods={"GET", "POST"})
     * @Template("/account/signin.twig")
     */
    public function signin(AuthenticationUtils $authenticationUtils) {
        
      if($this->getUser()) {
        $this->redirectToRoute('account_signin');
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
     * @access public
     * @Route("/account/signout", name="account_signout")
     */
    public function signout() {
        throw new \Exception();
    }
}
