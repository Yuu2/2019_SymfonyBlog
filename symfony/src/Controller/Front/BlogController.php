<?php

namespace App\Controller\Front;

use App\Form\ArticleType;
use App\Entity\Article;
use App\Service\BlogService;
use App\Service\CategoryService;
use App\Util\ValidationUtils;
use App\Util\BlogUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author yuu2dev
 * @todo 블로그 게시물 검색
 * updated 2020.06.10
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
    
    $hierarachyCategories = $categoryService->hierarachyCategories();
    
    return array(
      'Articles' => $blogService->pagingArticles($request),
      'Categories' => $categoryService->renderCategories($hierarachyCategories),
      'RecentArticles' => $blogService->recentArticles(10),
      'RecentTags' => $blogService->recentTags(30)
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

    $hierarachyCategories = $categoryService->hierarachyCategories();

    return array(
      'Article' => $article,
      'Categories' => $categoryService->renderCategories($hierarachyCategories),
      'RecentArticles' => $blogService->recentArticles(10),
      'RecentTags' => $blogService->recentTags(30)
    );
  }

  /**
   * 블로그 게시물 작성
   * @todo CKEditor 이미지 업로드 기능
   * @Route("/blog/new", name="blog_new", methods={"GET", "POST"})
   * @Template("front/blog/form.twig")
   * @access public
   * @param Request $request
   * @param BlogService $blogService
   * @param BlogUtils $blogUtils
   * @param CategoryService $categoryService
   * @param TranslatorInterface $translator
   * @param ValidationUtils $validationUtils
   * @return array|object
   */
  public function new(Request $request, BlogService $blogService, BlogUtils $blogUtils, CategoryService $categoryService, TranslatorInterface $translator, ValidationUtils $validationUtils) {
    
    $form = $this->createForm(ArticleType::class, new Article);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
      
      switch(true) {

        // CSRF Token 검증
        case !$validationUtils->verifyCsrfToken($request): break;

        default:
          /** @var String */
          $hashtag = $form->get('hashtag')->getData();
          $hashtagForm = $blogUtils->hashtagStringToArray($hashtag);
    
          /** @var Article */
          $article = $form->getData();
          
          if ($blogService->write($article, $hashtagForm)) {

            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
          } else {
            /** @todo 에러메시지 */
            $this->addFlash('msg', $translator->trans('front.blog.article.save_error'));
          }
      }
    }
    
    $hierarachyCategories = $categoryService->hierarachyCategories();

    return array(
      'form' => $form->createView(),
      'Categories' => $categoryService->renderCategories($hierarachyCategories),
      'RecentArticles' => $blogService->recentArticles(10),
      'RecentTags' => $blogService->recentTags(30)
    );
  }

  /**
   * @todo 리팩토링
   * 
   * 블로그 게시물 수정
   * @Route("/blog/edit/{id}", name="blog_edit", methods={"GET", "PUT"}, requirements={"id":"\d+"})
   * @Template("front/blog/form.twig")
   * @access public
   * @param Request $request
   * @param Article $article
   * @param BlogService $blogService
   * @param BlogUtils $blogUtils
   * @param CategoryService $categoryService
   * @param TranslatorInterface $translator
   * @param ValidationUtils $validationUtils
   * @return array|object
   */
  public function edit(Request $request, Article $article, BlogService $blogService,  BlogUtils $blogUtils, CategoryService $categoryService, TranslatorInterface $translator, ValidationUtils $validationUtils) {

    $form = $this->createForm(ArticleType::class, $article, ['method' => 'PUT']);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
      
      switch(true) {

        // CSRF Token 검증
        case !$validationUtils->verifyCsrfToken($request): break;
        
        default:

          /** @var String */
          $hashtag = $form->get('hashtag')->getData();
          
          $hashtagForm = $blogUtils->hashtagStringToArray($hashtag);
    
          /** @var Article */
          $article = $form->getData();
          
          if ($blogService->write($article, $hashtagForm)) {

            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
          } else {
            /** @todo 에러메시지 */
            $this->addFlash('msg', $translator->trans('front.blog.article.flash.msg_write_error'));
          }
      }
    }

    $hierarachyCategories = $categoryService->hierarachyCategories();

    return array(
      'form' => $form->createView(),
      'Categories' => $categoryService->renderCategories($hierarachyCategories),
      'RecentArticles' => $blogService->recentArticles(10),
      'RecentTags' => $blogService->recentTags(30)
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
    
    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    $blogService->removeArticle($article);

    return $this->redirectToRoute('blog_index');
  }
}
