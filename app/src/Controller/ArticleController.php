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
     * @Route("/article", name="article_index")
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
      
      return $this->render('article/index.html.twig', $data);
    }
    
    /**
     * @Route("/article/view{id}", name="article_show")
     * @access public
     */
    function show($id) {
      $entityManager = $this->getDoctrine()->getManager(); 

      $aside = new AsideService($entityManager);
      $data['Aside'] = $aside->execute();

      $article = new ArticleService($entityManager);
      $data['Article'] = $article->execute('show', null, $id);
      
      return $this->render('article/show.html.twig', $data);
    }
    /**
     * @Route("/article/new", name="article_new")
     * @access public
     */
    function new(Request $request) {

      $entityManager = $this->getDoctrine()->getManager();

      $aside = new AsideService($entityManager);
      $data['Aside'] = $aside->execute();

      $form = $this->createForm(ArticleType::class)->handleRequest($request);
      $data['form'] = $form->createView();
      $data['error'] = null;

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
