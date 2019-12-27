<?php

namespace App\Controller\Front\Blog;

use App\Entity\Article;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @author Yuu2
 */
class BlogController extends AbstractController {

    /**
     * 블로그 게시물 일람
     * @Route("/blog", name="blog_index")
     * @Template("front/Blog/index.twig")
     * @access public
     */
    public function index() {
      
      return array();
    }

    /**
     * 블로그 게시물 작성
     * @Route("/blog/new", name="blog_new")
     * @Template("front/blog/new.twig")
     * @access public
     */
    public function new() {
      
      return array();
    }

    /**
     * 블로그 게시물 수정
     * @Route("/blog/{id}", name="blog_edit")
     * @Template("front/blog/edit.twig")
     * @access public
     * @param Article $article
     */
    public function edit(Article $article) {

      return array();
    }
    
    /**
     * 게시글 상세
     * @Route("/article/view{target_id}", name="article_show")
     * @access public
     */
    /* 
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
    /*
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
    */
}
