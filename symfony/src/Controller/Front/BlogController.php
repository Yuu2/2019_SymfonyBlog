<?php

namespace App\Controller\Front;

use App\Form\ArticleType;
use App\Form\CommentType;
use App\Entity\Article;
use App\Entity\ArticleComment;
use App\Event\FlashEvent;
use App\Event\RedirectEvent;
use App\Service\BlogService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
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
 * @todo 블로그 게시물 검색
 * updated 2020.07.04
 */
class BlogController extends AbstractController {

  /**
   * 블로그 게시물 일람
   * @Route("/blog", name="blog_article_index", methods={"GET"})
   * @Template("front/Blog/index.twig")
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
   * @Route("/blog/article/{id}", name="blog_article_show", methods={"GET"}, requirements={"id":"\d+"})
   * @Entity("article", expr="repository.findArticleById(id)")
   * @Template("front/Blog/show.twig")
   * @access public
   * @param Article $article
   * @param BlogService $blogService
   * @param EventDispatcherInterface $eventDispatcher
   * @return array
   */
  public function article_show(?Article $article, BlogService $blogService, EventDispatcherInterface $eventDispatcher): array {
    
    $event = (new RedirectEvent)->setArticle($article);
    $eventDispatcher->dispatch(RedirectEvent::REDIRECT_IF_INVISIBLE_ARTICLE, $event);
    
    return array(
      'Article' => $article,
      'Articles_cnt' => $blogService->countArticles(),
      'Comment_cnt' => $blogService->countCommentsByEntity($article),
      'Categories' => $blogService->findCategories(),
      'RecentArticles' => $blogService->recentArticles(10),
      'RecentTags' => $blogService->recentTags(30)
    );
  }

  /**
   * 블로그 게시물 작성 및 수정
   * @todo CKEditor 이미지 업로드 기능
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
    
    $eventDispatcher->dispatch(RedirectEvent::REDIRECT_IF_NOT_ADMIN, new RedirectEvent('blog_article_index'));

    $form = $article ? $this->createForm(ArticleType::class, $article, ['method' => 'PUT']) : $this->createForm(ArticleType::class, new Article);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      
      /** @var String */
      $hashtag = $form->get('hashtag')->getData();
      $hashtagForm = $blogService->hashtagStringToArray($hashtag);
    
      /** @var Article */
      $article = $form->getData();
          
      if ($blogService->writeArticle($article, $hashtagForm)) {
        
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
   * @Route("/blog/article/delete/{id}", name="blog_article_delete", methods={"GET"}, requirements={"id":"\d+"})
   * @access public
   * @param Article $article
   * @param BlogService $blogService
   * @param EventDispatcherInterface $eventDispatcher
   * @param Request $request
   * @return object
   */
  public function article_delete(Article $article, BlogService $blogService, EventDispatcherInterface $eventDispatcher, Request $request): object {
    
    $eventDispatcher->dispatch(RedirectEvent::REDIRECT_IF_NOT_ADMIN, new RedirectEvent('blog_article_index'));

    $blogService->removeArticle($article);

    return $this->redirectToRoute('blog_index');
  }

  /**
   * 블로그 댓글 작성 및 수정
   * @Route("/blog/comment/new", name="blog_comment_new", methods={"GET", "POST"})
   * @Route("/blog/comment/edit/{id}", name="blog_comment_edit", methods={"GET", "PUT"}, requirements={"id":"\d+"})
   * @Template("front/blog/comment.twig")
   * @access public
   * @param ArticleComment $comment
   * @param BlogService $blogService
   * @param EventDispatcherInterface $eventDispatcher
   * @param Request $request
   * @return array|JsonResponse
   */
  public function comment_form(?ArticleComment $comment, BlogService $blogService, EventDispatcherInterface $eventDispatcher, Request $request) {
    
    if ($comment) {
      $form = $this->createForm(CommentType::class, $comment, ['action' => $this->generateUrl('blog_comment_new'), 'method' => 'PUT']);
    } else {
      $form = $this->createForm(CommentType::class, new ArticleComment, ['action' => $this->generateUrl('blog_comment_new'), 'method' => 'POST']);
    }

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      
      $eventDispatcher->dispatch(RedirectEvent::REDIRECT_IF_NOT_AUTH, new RedirectEvent('blog_article_index'));
    
      /** @var ArticleComment */
      $comment = $form->getData();
      
      $response = new JsonResponse;

      $blogService->writeComment($comment) ? $response->setStatusCode(Response::HTTP_OK) : $response->setStatusCode(Response::HTTP_FORBIDDEN);
      
      return $response;
    }

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * 블로그 댓글 삭제
   */
  public function comment_delete() {

  }
}
