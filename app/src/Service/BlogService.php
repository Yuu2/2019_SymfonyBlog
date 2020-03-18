<?php

namespace App\Service;

use App\Entity\Article;
use App\Repository\ArticleRepository;
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
  protected $entityManager;
  /**
   * @var ArticleRepository
   */
  protected $articleRepository;
  /**
   * @var TagRepository
   */
  protected $tagRepository;

  /**
   * @access public
   * @param EntityManagerInterface $entityManager
   * @param ArticleRepository $articleRepository
   * @param TagRepository $tagRepository
   */
  public function __construct(EntityManagerInterface $entityManager, ArticleRepository $articleRepository, TagRepository $tagRepository) {
    $this->entityManager = $entityManager;
    $this->articleRepository = $articleRepository;
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
   * 블로그 게시글 영속화
   * @param Article $article
   * @access public
   * @return void
   */
  public function saveArticle(Article $article) {


    $article->setCreatedAt(new \DateTime);

    $this->entityManager->persist($article);
    $this->entityManager->flush();
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
   * 블로그 모든 태그
   * @access public
   * @return array
   */
  public function allTags(): ?array {
    return $this->tagRepository->findAll();
  }

  /**
   * 블로그 해시태그 저장
   * @access public
   * @return boolean
   */
  public function saveTags() {
    $this->entityManager->getConnection()->beginTransaction();
    
    try {

      // @todo

      $this->entityManager->getConnection()->commit();
    } catch(\Exception $e) {
      $this->entityManager->getConnection()->rollback();
    }

    $this->tagRepoistory;
  } 
}