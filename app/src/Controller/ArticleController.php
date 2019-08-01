<?php

namespace App\Controller;

use App\Form\ArticleType;
use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends AbstractController {
  
    /**
     * @Route("/article", name="article")
     */
    public function index() {
      
      $entityManager = $this->getDoctrine()->getManager();

      $service = new ArticleService($entityManager);

      $data = $service->generate('article_index', null, null);
      
      return $this->render('article/index.html.twig', ['Articles' => $data]);
    }
    /**
     * @Route("/article/page/{article_id}", name="article_show")
     */
    public function show($article_id) {
      $entityManager = $this->getDoctrine()->getManager(); 
      $service = new ArticleService($entityManager);

      $article = $service->generate('article_show', null, $article_id);

      return $this->render('article/show.html.twig', [ 'Article' => $article[0] ]);
    }
    /**
     * @Route("/article/new", name="article_new")
     */
    public function new(Request $request) {

      $form = $this->createForm(ArticleType::class)->handleRequest($request);
      
      $data = ['form' => $form->createView(), 'error' => ''];

      $form_result = $form->isSubmitted() && $form->isValid(); 

      if(!$form_result) {
        return $this->render('article/new.html.twig', $data);
      }

      $form_data = $form->getData();

      $entityManager = $this->getDoctrine()->getManager();

      $service = new ArticleService($entityManager);
      $service->generate('article_new', $request, $form_data);

      return $this->redirectToRoute('article');
  }
}
