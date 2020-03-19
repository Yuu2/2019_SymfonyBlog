<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\Tag;
use App\Entity\ArticleTag;
use App\Repository\ArticleRepository;
use App\Repository\ArticleTagRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Yuu2
 * updated 2020.01.29
 */
class BlogService {

  /**
   * @var EntityManagerInterface
   */
  private $entityManager;
  
  /**
   * @var ArticleRepository
   */
  private $articleRepository;

  /**
   * @var ArticleTagRepository
   */
  private $articleTagRepository;

  /**
   * @var TagRepository
   */
  protected $tagRepository;

  /**
   * @access public
   * @param EntityManagerInterface $entityManager
   * @param ArticleRepository $articleRepository
   * @param ArticleTagRepository $articleTagRepository
   * @param TagRepository $tagRepository
   */
  public function __construct(
    EntityManagerInterface $entityManager, 
    ArticleRepository $articleRepository,
    ArticleTagRepository $articleTagRepository,
    TagRepository $tagRepository
  ) {
    $this->entityManager = $entityManager;
    $this->articleRepository = $articleRepository;
    $this->articleTagRepository = $articleTagRepository;
    $this->tagRepository = $tagRepository;
  }

  /**
   * 블로그 게시글 페이징
   * @access public
   * @param Request $request
   * @return Object
   */
  public function pagingArticles(Request $request): Object {

    $params = array(
      'category' => $request->query->get('category'),
      'page' => $request->query->get('page'),
      'search' => $request->query->get('search'),
      'tag' => $request->query->get('tag'),
    );

    return $this->articleRepository->paging($params);
  }

  /**
   * 최근 블로그 게시글
   * @access public
   * @param int $count
   * @return array
   */
  public function recentArticles(int $count = 10): ?array {

    return $this->articleRepository->recentArticles($count);
  }

  /**
   * 블로그 모든 태그
   * @access public
   * @return array
   */
  public function allTags(): ?array {

    return $this->tagRepository->findAll();
  }
  
  /**
   * 블로그 게시글 작성
   * @access public
   * @param Article $article
   * @param array $hashtagArr
   * @return bool
   */
  public function write(Article $article, array $hashtagArr): bool {
    
    $this->saveArticle($article, false);
    
    foreach ($hashtagArr as $hashtag) {
      
      $tag = new Tag();
      $tag->setName($hashtag);

      $this->saveTag($tag, false);
      $this->saveArticleTag($article, $tag, false);
    }

    $this->entityManager->flush();
    
    return $this->articleRepository->find($article->getId()) ? true : false;
  }

  /**
   * 블로그 게시글 영속화
   * @access public
   * @param Article $article
   * @param bool $flushFlag 
   * @return void
   */
  public function saveArticle(Article $article, bool $flushFlag = true): void {


    $article->setCreatedAt(new \DateTime);

    $this->entityManager->persist($article);
    
    $flushFlag ? $this->entityManager->flush() : null;
  }

  /**
   * 블로그 태그 영속화
   * @access public
   * @param Tag $tag
   * @param bool $flashFlag
   * @return void
   */
  public function saveTag(Tag $tag, bool $flashFlag = true): void {

    $this->entityManager->persist($tag);

    $flashFlag ? $this->entityManager->flush() : true;
  }

  /**
   * 블로그 게시글 - 태그 영속화
   * @access public
   * @param Article $article
   * @param Tag $tag
   * @param bool $flashFlag
   * @return void
   */
  public function saveArticleTag(Article $article, Tag $tag, bool $flashFlag = true): void {
    
    /** @var ArticleTag */
    $articleTag = new ArticleTag();
    $articleTag->setArticle($article);
    $articleTag->setTag($tag);

    $this->entityManager->persist($articleTag);

    $flashFlag ? $this->entityManager->flush() : true;
  }

  /**
   * 블로그 게시글 삭제
   * @access public
   * @param Article $article
   * @return void
   */
  public function removeArticle(Article $article): void {

    $this->entityManager->remove($article);
    $this->entityManager->flush();
  }

  /**
   * 블로그 게시글 삭제
   * @access public
   * @param Tag $tag
   * @return void
   */
  public function removeTag(Tag $tag): void {

    $this->entityManager->remove($tag);
    $this->entityManager->flush();
  }
}




/*
$this->entityManager->getConnection()->beginTransaction();
    
try {

  // @todo 일괄처리




  $this->entityManager->getConnection()->commit();
  return true;

} catch(\Exception $e) {
  $this->entityManager->getConnection()->rollback();
  return false;
}