<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\ArticleTag;
use App\Entity\Tag;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author yuu2dev
 * updated 2020.06.30
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
   * @var CategoryRepository
   */
  private $categoryRepository;

  /**
   * @var TagRepository
   */
  protected $tagRepository;

  /**
   * @access public
   * @param EntityManagerInterface $entityManager
   * @param ArticleRepository $articleRepository
   * @param CategoryRepository $categoryRepository
   * @param TagRepository $tagRepository
   */
  public function __construct(
    EntityManagerInterface $entityManager, 
    ArticleRepository $articleRepository,
    CategoryRepository $categoryRepository,
    TagRepository $tagRepository
  ) {
    $this->entityManager = $entityManager;
    $this->articleRepository = $articleRepository;
    $this->categoryRepository = $categoryRepository;
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
   * 총 게시글 수
   * @access public
   * @return string
   */
  public function countArticles(): ?string {
    return $this->articleRepository->countArticles();
  }

  /**
   * 최근 블로그 태그
   * @access public
   * @param int $count
   * @return array
   */
  public function recentTags(int $count = 30): ?array {

    return $this->tagRepository->countTags($count);
  }
  
  /**
   * @access public
   * @return array
   */
  public function findCategories(): ?array {
    
    return $this->categoryRepository->visibleCategories();
  }

  /**
   * 블로그 게시글 작성
   * @access public
   * @param Article $article
   * @param array $hashtagForm
   * @return bool
   */
  public function write(Article $article, array $hashtags): bool {
    
    try {
      
      $artitags = [];
      
      foreach($article->getTag() as $tag) {

        $artitags[] = $tag->getName();
      }

      // 해시태그 주입 시 
      foreach(array_diff($hashtags, $artitags) as $hashtag) {

        $tag = new Tag();
        
        $tag->setName($hashtag);
        $tag->setCreatedAt(new \DateTime);
        
        $this->entityManager->persist($tag);

        $article->addTag($tag);
      }

      // 해시태그 삭제 시
      foreach(array_diff($artitags, $hashtags) as $hashtag) {
        
        foreach($article->getTag() as $tag) {
          
          if($tag->getName() == $hashtag) {
            $article->removeTag($tag);
          }
        }
      }
      
      $article->setCreatedAt(new \DateTime);

      $this->entityManager->persist($article);
      $this->entityManager->flush();

      return true;
    
    } catch(\Exception $e) {

      return false;
    }
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

  /**
   * 해시태그 문자열을 배열로
   * @access public
   * @param string $hashtag
   * @return array
   */
  public function hashtagStringToArray(?string $hashtag): array {
    
    $hashtagArr = [];

    if (!empty($hashtag)) {
      $hashtagArr = explode(',', $hashtag);
    }

    return $hashtagArr;
  }
}