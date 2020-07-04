<?php

namespace App\Controller\Front;

use App\Form\ArticleType;
use App\Entity\Article;
use App\Event\FlashEvent;
use App\Event\RedirectEvent;
use App\Service\BlogService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author yuu2dev
 * @todo 블로그 게시물 검색
 * updated 2020.07.04
 */
class BlogController extends AbstractController {

  /**
   * 블로그 게시물 일람
   * @Route("/blog", name="blog_index", methods={"GET"})
   * @Template("front/Blog/index.twig")
   * @access public
   * @param Request $request
   * @param BlogService $blogService
   * @return array
   */
  public function index(Request $request, BlogService $blogService): array {
    
    return array(
      'Articles' => $blogService->pagingArticles($request),
      'Articles_cnt' => $blogService->countArticles(),
      'Categories' => $blogService->findCategories(),
      'RecentArticles' => $blogService->recentArticles(10),
      'RecentTags' => $blogService->recentTags(30)
    );
  }

  /**
   * 블로그 게시물 상세
   * @Route("/blog/{id}", name="blog_show", methods={"GET"}, requirements={"id":"\d+"})
   * @Entity("article", expr="repository.findArticleById(id)")
   * @Template("front/Blog/show.twig")
   * @access public
   * @param Article $article
   * @param BlogService $blogService
   * @param EventDispatcherInterface $eventDispatcher
   * @return array
   */
  public function show(?Article $article, BlogService $blogService, EventDispatcherInterface $eventDispatcher): array {
    
    $event = new RedirectEvent;
    $event->setArticle($article);

    $eventDispatcher->dispatch(RedirectEvent::REDIRECT_IF_INVISIBLE_ARTICLE, $event);

    return array(
      'Article' => $article,
      'Articles_cnt' => $blogService->countArticles(),
      'Categories' => $blogService->findCategories(),
      'RecentArticles' => $blogService->recentArticles(10),
      'RecentTags' => $blogService->recentTags(30)
    );
  }

  /**
   * 블로그 게시물 작성 및 수정
   * @todo CKEditor 이미지 업로드 기능
   * @Route("/blog/new", name="blog_new", methods={"GET", "POST"})
   * @Route("/blog/edit/{id}", name="blog_edit", methods={"GET", "PUT"}, requirements={"id":"\d+"})
   * @Template("front/blog/form.twig")
   * @access public
   * @param Article $article
   * @param BlogService $blogService
   * @param EventDispatcherInterface $eventDispatcher
   * @param Request $request
   * @param TranslatorInterface $translator
   * @return array|object
   */
  public function new(?Article $article, Request $request, BlogService $blogService, EventDispatcherInterface $eventDispatcher, TranslatorInterface $translator) {
    
    $eventDispatcher->dispatch(RedirectEvent::REDIRECT_IF_NOT_ROLE_ADMIN, new RedirectEvent('blog_index'));

    $form = $article ? $this->createForm(ArticleType::class, $article, ['method' => 'PUT']) : $this->createForm(ArticleType::class, new Article);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      
      /** @var String */
      $hashtag = $form->get('hashtag')->getData();
      $hashtagForm = $blogService->hashtagStringToArray($hashtag);
    
      /** @var Article */
      $article = $form->getData();
          
      if ($blogService->write($article, $hashtagForm)) {
        
        $eventDispatcher->dispatch(FlashEvent::BLOG_ARTICLE_WRITE_SUCCESS);
        return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);

      } else {
        $eventDispatcher->dispatch(FlashEvent::BLOG_ARTICLE_WRITE_FAIL);
      }
    }

    return array(
      'form' => $form->createView(),
      'Categories' => $blogService->findCategories(),
      'RecentArticles' => $blogService->recentArticles(10),
      'RecentTags' => $blogService->recentTags(30)
    );
  }

  /**
   * 블로그 게시물 삭제
   * @Route("/blog/delete/{id}", name="blog_delete", methods={"GET"}, requirements={"id":"\d+"})
   * @access public
   * @param Article $article
   * @param BlogService $blogService
   * @param EventDispatcherInterface $eventDispatcher
   * @param Request $request
   * @return object
   */
  public function delete(Article $article, BlogService $blogService, EventDispatcherInterface $eventDispatcher, Request $request): object {
    
    $eventDispatcher->dispatch(RedirectEvent::REDIRECT_IF_NOT_ROLE_ADMIN, new RedirectEvent('blog_index'));

    $blogService->removeArticle($article);

    return $this->redirectToRoute('blog_index');
  }
}
