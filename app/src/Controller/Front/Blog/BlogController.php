<?php

namespace App\Controller\Front\Blog;

use App\Form\ArticleType;
use App\Service\ArticleService;
use App\Service\AsideService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @author Yuu2
 */
class BlogController extends AbstractController {
    /** 
     * @var Array $data
     */
    private $data;

    /**
     * 게시글 일람
     * @Route("/article", name="article_index")
     * @access public
     */
    function index() {
      
      $entityManager = $this->getDoctrine()->getManager();
      $request = Request::createFromGlobals();
      
      $aside = new AsideService($entityManager);
      $data['Aside'] = $aside->execute();

      $article = new ArticleService($entityManager);
      
      $data['Articles'] = $article->execute('index', $request, null, null);
      $data['PageInfo'] = $article->execute('paging', $request, null, null);
      
      return $this->render('article/index.html.twig', $data);
    }
    
    /**
     * 게시글 상세
     * @Route("/article/view{target_id}", name="article_show")
     * @access public
     */
    function show($target_id) {
      $entityManager = $this->getDoctrine()->getManager(); 

      $aside = new AsideService($entityManager);
      $data['Aside'] = $aside->execute();

      $article = new ArticleService($entityManager);
      $data['Article'] = $article->execute('show', null, $target_id, null);
      
      return $this->render('article/show.html.twig', $data);
    }
    /**
     * 게시글 작성
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

      $session = new Session();
      $article = new ArticleService($entityManager);
      $article->execute('new', $request, $form_data, $session);

      return $this->redirectToRoute('article_index');
  }
}
