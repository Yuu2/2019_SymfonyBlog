<?php

namespace App\Controller;

use App\Form\ArticleType;
use App\Service\ArticleService;
use App\Service\AsideService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends AbstractController {
    /** 
     * @var Array $data
     */
    private $data;

    /**
     * 게시판 일람
     * @Route("/article", name="article")
     * @access public
     */
    function index() {
      
      $entityManager = $this->getDoctrine()->getManager();
      $request = Request::createFromGlobals();
      
      $aside = new AsideService($entityManager);
      $data['Aside'] = $aside->execute();

      $article = new ArticleService($entityManager);
      
      $data['Articles'] = $article->execute('index', $request, null);
      $data['PageInfo'] = $article->execute('paging', $request, null);
      
      dump($data); // TEMP
      
      return $this->render('article/index.html.twig', $data);
    }
    
    /**
     * @Route("/article/page/{article_id}", name="article_show")
     * @access public
     * @todo 미완성
     */
    function show($article_id) {
      $entityManager = $this->getDoctrine()->getManager(); 
      $service = new ArticleService($entityManager);

      $article = $service->generate('article_show', null, $article_id);

      return $this->render('article/show.html.twig', [ 'Article' => $article[0] ]);
    }
    /**
     * @Route("/article/new", name="article_new")
     * @access public
     * @todo 미완성
     */
    function new(Request $request) {
      $entityManager = $this->getDoctrine()->getManager();
      $form = $this->createForm(ArticleType::class)->handleRequest($request);
      
      $data = ['form' => $form->createView(), 'error' => ''];
      $aside = new AsideService($entityManager);
      $data['Aside'] = $aside->execute();

      $form_result = $form->isSubmitted() && $form->isValid(); 

      if(!$form_result) {
        return $this->render('article/new.html.twig', $data);
      }

      $form_data = $form->getData();


      $service = new ArticleService($entityManager);
      $service->execute('article_new', $request, $form_data);

      return $this->redirectToRoute('article');
  }
}
