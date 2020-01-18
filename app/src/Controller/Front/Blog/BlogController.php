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
     * @Route("/blog", name="blog_index", methods={"GET"})
     * @Template("front/Blog/index.twig")
     * @access public
     */
    public function index() {
      
      return array();
    }
    /**
     * 블로그 게시물 상세
     * @Route("/blog/{id}", name="blog_show", methods={"GET"})
     * @Template("front/Blog/index.twig")
     * @access public
     * @param Article $article
     */
    public function show(Article $article) {

      return array();
    }

    /**
     * 블로그 게시물 작성
     * @Route("/blog/new", name="blog_new", methods={"GET"})
     * @Template("front/blog/new.twig")
     * @access public
     */
    public function new() {
      
      return array();
    }

    /**
     * 블로그 게시물 수정
     * @Route("/blog/edit/{article}", name="blog_edit", methods={"GET"})
     * @Template("front/blog/edit.twig")
     * @access public
     * @param Article $article
     */
    public function edit(Article $article) {

      return array();
    }


}
