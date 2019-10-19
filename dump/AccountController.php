<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\SignInType;
use App\Form\SignUpType;
use App\Service\AccountService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use ReCaptcha\ReCaptcha;


class AccountController extends AbstractController {
    
    /**
     * @Route("/signin", name="signin")
     */
    public function signin(Request $request) {

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
     * @Route("/signout", name="signout")
     */
    public function signout() {

      $service = new AccountService(null);
      $service->execute('signout', null, null, null);
      
      return $this->redirectToRoute('route');
    }
}





// *** with Rails API ***
// $httpClient = HttpClient::create();
// $response = $httpClient->request('GET', 'http://localhost:3001/tests');
        