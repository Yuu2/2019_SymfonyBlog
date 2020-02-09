<?php

namespace App\Controller\Front\Blog;

use App\Form\ArticleType;
use App\Entity\Article;
use App\Service\BlogService;
use App\Service\CategoryService;
use App\Util\CustomUtil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @author Yuu2
 * @todo 블로그 게시물 검색
 * updated 2020.01.27
 */
class BlogController extends AbstractController {

  /**
   * 블로그 게시물 일람
   * @Route("/blog", name="blog_index", methods={"GET"})
   * @Template("front/Blog/index.twig")
   * @access public
   * @param Request $request
   * @param BlogService $blogService
   * @param CategoryService $categoryService
   * @return array
   */
  public function index(Request $request, BlogService $blogService, CategoryService $categoryService): array {
    
    $categories = $categoryService->hierarachy();
    
    return array(
      'Articles' => $blogService->articles($request),
      'Categories' => $categoryService->categories($categories),
      'RecentArticles' => $blogService->recentArticles(10),
      'Tags' => $blogService->tags()
    );
  }

  /**
   * 블로그 게시물 상세
   * @Route("/blog/{id}", name="blog_show", methods={"GET"}, requirements={"id":"\d+"})
   * @Template("front/Blog/show.twig")
   * @access public
   * @param Article $article
   * @param BlogService $blogService
   * @param CategoryService $categoryService
   * @return array
   */
  public function show(Article $article, BlogService $blogService, CategoryService $categoryService): array {

    $categories = $categoryService->hierarachy();

    return array(
      'Article' => $article,
      'Categories' => $categoryService->categories($categories),
      'RecentArticles' => $blogService->recentArticles(10),
      'Tags' => $blogService->tags()
    );
  }

  /**
   * 블로그 게시물 작성
   * @Route("/blog/new", name="blog_new", methods={"GET", "POST"})
   * @Template("front/blog/form.twig")
   * @access public
   * @param Request $request
   * @param BlogService $blogService
   * @param CategoryService $categoryService
   * @param CustomUtil $customUtil
   * @return array|object
   */
  public function new(Request $request, BlogService $blogService, CategoryService $categoryService, CustomUtil $customUtil) {
    
    $form = $this->createForm(ArticleType::class, new Article);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
      
      switch(true) {
        // CSRF Token 검증
        case !$customUtil->verifyCsrfToken($request): break;
        default:
        /** @var Article */
        $article = $form->getData();
        $blogService->save($article);
        return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
      }
    }
    
    $categories = $categoryService->hierarachy();

    return array(
      'form' => $form->createView(),
      'Categories' => $categoryService->categories($categories),
      'RecentArticles' => $blogService->recentArticles(10),
      'Tags' => $blogService->tags()
    );
  }

  /**
   * 블로그 게시물 수정
   * @Route("/blog/edit/{id}", name="blog_edit", methods={"GET", "PUT"}, requirements={"id":"\d+"})
   * @Template("front/blog/form.twig")
   * @access public
   * @param Request $request
   * @param Article $article
   * @param BlogService $blogService
   * @return array|object
   */
  public function edit(Request $request, Article $article, BlogService $blogService, CategoryService $categoryService, CustomUtil $customUtil) {

    $form = $this->createForm(ArticleType::class, $article, ['method' => 'PUT']);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
      
      switch(true) {
        // CSRF Token 검증
        case !$customUtil->verifyCsrfToken($request): break;
        default:
        /** @var Article */
        $article = $form->getData();
        $blogService->save($article);
        return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
      }
    }

    $categories = $categoryService->hierarachy();

    return array(
      'form' => $form->createView(),
      'Categories' => $categoryService->categories($categories),
      'RecentArticles' => $blogService->recentArticles(10),
      'Tags' => $blogService->tags()
    );
  }

  /**
   * 블로그 게시물 삭제
   * @Route("/blog/delete/{id}", name="blog_delete", methods={"DELETE"}, requirements={"id":"\d+"})
   * @access public
   * @param Request $request
   * @param Article $article
   * @param BlogService $blogService
   * @return object
   */
  public function delete(Request $request, Article $article, BlogService $blogService): object {
    
    $blogService->remove($article);

    return $this->redirectToRoute('blog_index');
  }
}
