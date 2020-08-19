<?php

namespace App\Controller\Front;

use App\Form\ArticleType;
use App\Form\ArticleCommentType;
use App\Form\ArticleCommentVerifyType;
use App\Entity\Article;
use App\Entity\ArticleComment;
use App\Event\FlashEvent;
use App\Event\RedirectEvent;
use App\Service\BlogService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author yuu2dev
 * @todo 댓글 검증 삭제 수정
 * updated 2020.08.20
 */
class BlogController extends AbstractController {

  /**
   * @access public
   */
  public function __construct() {}

  /**
   * 블로그 게시물 일람
   * @Route("/blog", name="blog_article_index", methods={"GET"})
   * @Template("front/blog/index.twig")
   * @access public
   * @param Request $request
   * @param BlogService $blogService
   * @return array
   */
  public function article_index(Request $request, BlogService $blogService): array {
    
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
   * @Route("/blog/article/{id}", name="blog_article_show", methods={"GET", "POST"}, requirements={"id":"\d+"})
   * @Entity("article", expr="repository.findArticleById(id)")
   * @Template("front/blog/show.twig")
   * @access public
   * @param Article $article
   * @param BlogService $blogService
   * @param EventDispatcherInterface $eventDispatcher
   * @param Request $request
   * @return array
   */
  public function article_show(?Article $article, BlogService $blogService, EventDispatcherInterface $eventDispatcher, Request $request) {
    
    if (!$article) {
      $eventDispatcher->dispatch(FlashEvent::BLOG_ARTICLE_INVISIBLE);
      $eventDispatcher->dispatch(RedirectEvent::REDIRECT, new RedirectEvent);
    }
    
    $form = $this->createForm(ArticleCommentType::class, new ArticleComment, ['method' => 'post']);
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
      /** @var ArticleComment */
      $comment = $form->getData();
      $comment->setArticle($article);
      
      $blogService->writeComment($comment) ? $eventDispatcher->dispatch(FlashEvent::BLOG_ARTICLE_COMMENT_WRITE_SUCCESS) : $eventDispatcher->dispatch(FlashEvent::BLOG_ARTICLE_COMMENT_WRITE_FAILED);
      return $this->redirect($request->getUri());
    }

    return [
      'Article' => $article,
      'Articles_cnt' => $blogService->countArticles(),
      'Comment_cnt' => $blogService->countCommentsByEntity($article),
      'Categories' => $blogService->findCategories(),
      'RecentArticles' => $blogService->recentArticles(10),
      'RecentTags' => $blogService->recentTags(30),
      'CommentForm' => $form->createView(),
    ];
  }

  /**
   * 블로그 게시물 작성 및 수정
   * @Route("/blog/article/new", name="blog_article_new", methods={"GET", "POST"})
   * @Route("/blog/article/edit/{id}", name="blog_article_edit", methods={"GET", "PUT"}, requirements={"id":"\d+"})
   * @Template("front/blog/form.twig")
   * @access public
   * @param Article $article
   * @param BlogService $blogService
   * @param EventDispatcherInterface $eventDispatcher
   * @param Request $request
   * @param TranslatorInterface $translator
   * @return array|object
   */
  public function article_form(?Article $article, Request $request, BlogService $blogService, EventDispatcherInterface $eventDispatcher, TranslatorInterface $translator) {
    
    $form = $article ? $this->createForm(ArticleType::class, $article, ['method' => 'put']) : $this->createForm(ArticleType::class, new Article);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      
      /** @var String */
      $hashtag = $form->get('hashtag')->getData();
      $hashtagForm = $blogService->hashtagStringToArray($hashtag);
    
      /** @var Article */
      $article = $form->getData();
          
      $blogService->writeArticle($article, $hashtagForm) ? $eventDispatcher->dispatch(FlashEvent::BLOG_ARTICLE_WRITE_SUCCESS) : $eventDispatcher->dispatch(FlashEvent::BLOG_ARTICLE_WRITE_FAILED);
      
      return $this->redirectToRoute('blog_article_show', ['id' => $article->getId()]);
    }

    return [
      'form' => $form->createView(),
      'Categories' => $blogService->findCategories(),
      'RecentArticles' => $blogService->recentArticles(10),
      'RecentTags' => $blogService->recentTags(30)
    ];
  }

  /**
   * 블로그 게시물 삭제
   * @Route("/blog/article/del/{id}", name="blog_article_del", methods={"GET"}, requirements={"id":"\d+"})
   * @access public
   * @param Article $article
   * @param BlogService $blogService
   * @param EventDispatcherInterface $eventDispatcher
   * @param Request $request
   * @return object
   */
  public function article_del(Article $article, BlogService $blogService, EventDispatcherInterface $eventDispatcher, Request $request): object {
    
    $blogService->removeArticle($article);

    return $this->redirectToRoute('blog_article_index');
  }

  /**
   * 블로그 댓글 수정
   * @Route("/blog/comment/edit/{id}", name="blog_comment_edit", methods={"GET", "PUT"}, requirements={"id":"\d+"})
   */
  public function comment_edit(ArticleComment $comment, BlogService $blogService, EventDispatcherInterface $eventDispatcher, Request $request) {
    // $form = $this->createForm(CommentType::class, $comment, ['action' => $this->generateUrl('blog_comment_new'), 'method' => 'PUT']);
  }

  /**
   * 블로그 댓글 삭제
   * @Route("/blog/article/comment/del/{id}", name="blog_comment_del", methods={"GET", "DELETE"}, requirements={"id":"\d+"})
   * @access public
   * @param ArticleComment $comment
   * @param BlogService $blogService
   * @param EventDispatcherInterface $eventDispatcher
   * @param Request $request
   */
  public function comment_del(ArticleComment $comment, BlogService $blogService, EventDispatcherInterface $eventDispatcher, Request $request) {
      
    $response = new Response;

    /**
     * @todo 익명 세션 검증
     */
    if ($this->getUser() == $comment->getUser()) {
    
      $blogService->removeComment($comment) ? $eventDispatcher->dispatch(FlashEvent::BLOG_ARTICLE_COMMENT_DEL_SUCCESS) : $eventDispatcher->dispatch(FlashEvent::BLOG_ARTICLE_COMMENT_DEL_FAILED);
    }

    return $this->redirectToRoute('blog_article_show', ['id' => $comment->getArticle()->getId()]);
  }

  /**
   * @todo
   * 블로그 댓글 검증
   * @Route("/blog/article/comment/verify/{id}", name="blog_comment_verify", methods={"GET","POST"}, requirements={"id":"\d+"})
   * @param ArticleComment $comment
   * @param BlogService $blogService
   * @param EventDispatcherInterface $eventDispatcher
   * @param Request $request
   */
  public function comment_verify(ArticleComment $comment, BlogService $blogService, EventDispatcherInterface $eventDispatcher, Request $request) {

    $response = new Response;

    $form = $this->createForm(ArticleCommentVerifyType::class, new ArticleComment, ['method' => 'post']);
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
      $password = $request->request->get('password');
      
      /**
       * @todo 세션등록
       */
      // password_verify($password, $comment->getPassword()) ? $respose->setStatusCode(Response::HTTP_OK) : $response->setStatusCode(Response::HTTP_FORBIDDEN);
    }
    
    $response->setContent(
      $this->render('front/blog/comment/form_verify.twig', ['form' => $form->createView()])->getContent()
    );

    return $response;
  }
}
