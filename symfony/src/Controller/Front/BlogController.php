<?php

namespace App\Controller\Front;

use App\Form\ArticleType;
use App\Form\ArticleCommentType;
use App\Form\ArticleCommentCertType;
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
    
    $form = $this->createForm(ArticleCommentType::class, new ArticleComment, ['method' => 'post', 'branch' => 'NEW']);
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
      /** @var ArticleComment */
      $comment = $form->getData();
      $comment->setArticle($article);
      
      $blogService->writeComment($comment) ? $eventDispatcher->dispatch(FlashEvent::BLOG_ARTICLE_COMMENT_WRITE_SUCCESS) : $eventDispatcher->dispatch(FlashEvent::BLOG_ARTICLE_COMMENT_WRITE_FAILED);
      
      return $this->redirectToRoute('blog_article_show', ['id' => $article->getId()]);
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
   * @todo
   * 블로그 댓글 작성
   * @Route("/blog/comment/new", name="blog_comment_new", methods={"GET", "POST"})
   * @access public
   * @param BlogService $blogService
   * @param EventDispatcherInterface $eventDispatcher
   * @param Request $request
   */
  public function comment_new(BlogService $blogService, EventDispatcherInterface $eventDispatcher, Request $request) {}

  /**
   * 블로그 댓글 수정
   * @Route("/blog/comment/edit/{id}", name="blog_comment_edit", methods={"GET", "PUT"}, requirements={"id":"\d+"})
   * @access public
   * @param BlogService $blogService
   * @param EventDispatcherInterface $eventDispatcher
   * @param Request $request
   * @return JsonResponse
   */
  public function comment_edit(ArticleComment $comment, BlogService $blogService, EventDispatcherInterface $eventDispatcher, Request $request) {
    
    $response = new JsonResponse;

    $form = $this->createForm(ArticleCommentType::class, $comment, ['method' => 'post', 'branch' => 'EDIT']);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      /** @todo */
    }

    $data['form'] = $this->render('front/blog/comment/form_edit.twig', ['form' => $form->createView()])->getContent(); 

    return $response->setData($data);
  }

  /**
   * 블로그 댓글 삭제
   * @Route("/blog/comment/del/{id}", name="blog_comment_del", methods={"GET","DELETE"}, requirements={"id":"\d+"})
   * @access public
   * @param ArticleComment $comment
   * @param BlogService $blogService
   * @param EventDispatcherInterface $eventDispatcher
   * @param Request $request
   * @return JsonResposnse
   */
  public function comment_del(ArticleComment $comment, BlogService $blogService, EventDispatcherInterface $eventDispatcher, Request $request): JsonResponse {
    
    $response = new JsonResponse;
    $session = $request->getSession();
    
    /** @todo 리팩토링 */
    $isAnony = $session->get('comment') == $comment->getId();
    $isMember = $this->getUser() == $comment->getUser();

    if ($isAnony || $isMember) {
     
      $blogService->removeComment($comment) ? $eventDispatcher->dispatch(FlashEvent::BLOG_ARTICLE_COMMENT_DEL_SUCCESS) : $eventDispatcher->dispatch(FlashEvent::BLOG_ARTICLE_COMMENT_DEL_FAILED);
    }

    return $request->isXmlHttpRequest() ? $response : $this->redirectToRoute('blog_article_show', ['id' => $article->getId()]);
  }

  /**
   * 블로그 댓글 검증
   * @Route("/blog/article/comment/cert/{id}", name="blog_comment_verify", methods={"GET","POST"}, requirements={"id":"\d+"})
   * @param ArticleComment $comment
   * @param BlogService $blogService
   * @param EventDispatcherInterface $eventDispatcher
   * @param Request $request
   * @return JsonResponse
   */
  public function comment_cert(ArticleComment $comment, BlogService $blogService, EventDispatcherInterface $eventDispatcher, Request $request) {

    $branch = $request->query->get('branch');
    
    $response = new JsonResponse;
    
    $form = $this->createForm(ArticleCommentCertType::class, new ArticleComment, [
      'method'  => 'post', 
      'action'  => $this->generateUrl('blog_comment_verify', ['id' => $comment->getId()]) . '?branch=' . $branch,
      'comment' => $comment      
    ]);

    $form->handleRequest($request);
    
    $session = $request->getSession();

    if ($form->isSubmitted() && $form->isValid()) {
      
      switch(mb_strtoupper($branch)) {
        // 삭제
        case 'DEL':

          $session->set('comment_del', $comment->getId());
          
          $data = [
            'url' => $this->generateUrl('blog_comment_del', ['id' => $comment->getId()]),
            'branch' => 'DEL'
          ];
          
          $response->setStatusCode(Response::HTTP_FOUND);
        break;
        // 수정
        case 'EDIT':

          $session->set('comment_edit', $comment->getId());
          
          $data = [
            'url' => $this->generateUrl('blog_comment_edit', ['id' => $comment->getId()]),
            'branch' => 'EDIT'
          ];

          $response->setStatusCode(Response::HTTP_FOUND);
        break;
        default:
          $response->setStatusCode(Response::HTTP_BAD_REQUEST);
      }
    } else {
      /** @todo 다른 세션까지 지워버리는거 아니야? */
      $session->clear();
    }

    $data['form'] = $this->render('front/blog/comment/form_cert.twig', ['form' => $form->createView()])->getContent(); 

    return $response->setData($data);
  }
}
