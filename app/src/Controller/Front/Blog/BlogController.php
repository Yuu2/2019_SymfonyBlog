<?php

namespace App\Controller\Front\Blog;

use App\Entity\Article;
use App\Service\BlogService;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @author Yuu2
 * @todo 블로그 게시물 검색
 * updated 2020.01.19
 */
class BlogController extends AbstractController {

  /**
   * 블로그 게시물 일람
   * @Route("/blog", name="blog_index", methods={"GET"})
   * @Template("front/Blog/index.twig")
   * @access public
   * @param BlogService $blogService
   * @return array
   */
  public function index(Request $request, BlogService $blogService): ?array {
    
    $query = array(
      'page' => $request->get('page'),
      'search' => $request->get('search'),
      'tag' => $request->get('tag'),
    );
    
    return array(
      'Articles' => $blogService->articles($query),
      'Tags' => $blogService->tags()
    );
  }

  /**
   * 블로그 게시물 상세
   * @Route("/blog/{id}", name="blog_show", methods={"GET"})
   * @Template("front/Blog/show.twig")
   * @access public
   * @param Article $article
   * @param BlogService $blogService
   * @return array
   */
  public function show(Article $article, BlogService $blogService): ?array {

    return array(
      'Article' => $article,
      'Tags' => $blogService->tags()
    );
  }

  /**
   * 블로그 게시물 작성
   * @Route("/blog/new", name="blog_new", methods={"GET"})
   * @Template("front/blog/form.twig")
   * @access public
   * @param Request $request
   * @param BlogService $blogService
   * @return array
   */
  public function new(Request $request, BlogService $blogService): ?array {
    
    return array();
  }

  /**
   * 블로그 게시물 수정
   * @Route("/blog/edit/{id}", name="blog_edit", methods={"GET"})
   * @Template("front/blog/form.twig")
   * @access public
   * @param Article $article
   * @param BlogService $blogService
   * @return array
   */
  public function edit(Article $article, BlogService $blogService): ?array {

    return array();
  }

  /**
   * 블로그 게시물 영속화
   * @Route("/blog/new", name="blog_save", methods={"POST"})
   * @access public
   * @param Request $request
   * @param BlogService $blogService
   * @return array
   */
  public function save(Request $request, BlogService $blogService): ?array {
    
    return array();
  }

  /**
   * 블로그 게시물 삭제
   * @Route("/blog/delete/{id}", name="blog_delete", methods={"DELETE"})
   * @access public
   */
  public function delete(Article $article) {

    return array();
  }
}
