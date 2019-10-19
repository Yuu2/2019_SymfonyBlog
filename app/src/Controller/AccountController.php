<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\SignInType;
use App\Form\SignUpType;
// use App\Service\AccountService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use ReCaptcha\ReCaptcha;


/**
 * @author Yuu2
 * 리팩토링중 ...
 */
class AccountController extends AbstractController {
    
    /**
     * 로그인
     * @Route("/login", name="signin")
     */
    public function login(Request $request) {

      $form = $this->createForm(SignInType::class)->handleRequest($request);

      $data = ['form' => $form->createView(), 'error' => ''];

      $form_result = $form->isSubmitted() && $form->isValid(); 

      if(!$form_result) {
        return $this->render('signin.html.twig', $data);
      }

      $form_data = $form->getData();
  
      $entityManager = $this->getDoctrine()->getManager();

      $service = new AccountService($entityManager);
      $service->execute('signin', $request, $form_data, $_SERVER['RECAPTCHA_SECRET_KEY']);

      $data['error'] = $service->error;

      if(empty($data['error'])) {
        $session = new Session;
        $data['session'] =  $session->get('e-mail');
        return $this->redirectToRoute('route');
      } else {
        return $this->render('signin.html.twig', $data);
      }
    }

    /**
     * 회원가입
     * @Route("/signup", name="signup")
     */
    public function signup(Request $request):Response {

      $form = $this->createForm(SignUpType::class)->handleRequest($request);
      
      $data = ['form' => $form->createView(), 'error' => ''];
      
      $form_result = $form->isSubmitted() && $form->isValid(); 
      
      if(!$form_result) {
        return $this->render('signup.html.twig', $data);
      }

      $form_data = $form->getData();

      $entityManager = $this->getDoctrine()->getManager();

      $service = new AccountService($entityManager);
      $service->execute('signup', $request, $form_data, $_SERVER['RECAPTCHA_SECRET_KEY']);
      
      $data['error'] = $service->error;
 
      if(is_null($data['error'])) {
        return $this->redirectToRoute('route');
      } else {
        return $this->render('signup.html.twig', $data);
      }
    }
    /**
     * 로그아웃
     * @Route("/logout", name="logout")
     */
    public function logout() {

      $service = new AccountService(null);
      $service->execute('signout', null, null, null);
      
      return $this->redirectToRoute('route');
    }
}