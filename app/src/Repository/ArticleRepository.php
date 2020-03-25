<?php

namespace App\Repository;

use App\Entity\Article;
use App\Util\CustomValidator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @author Yuu2
 * updated 2020.01.19
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository {

  /**
   * @access public
   * @param ManagerRegistry $registry
   * @param PaginatorInterface $paginatorInterface
   */
  public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator) {
    parent::__construct($registry, Article::class);
    $this->paginator = $paginator;
  }

  /**
   * 게시글 일람 쿼리
   * @access public
   * @param array $query
   * @return Object
   */
  public function paging(array $params): ?Object {
    
    $category = $params['category'];
    $page     = $params['page'];
    $tag      = $params['tag'];

    $category = is_numeric($category) ? $category : NULL;
    $page     = is_numeric($page)     ? $page     : 1;

    $search = $params['search'];

    $query = $this->createQueryBuilder('a');
    
    switch(true) {
      // 카테고리
      case $category:
        $query
          ->innerJoin('a.category', 'c')
          ->where('c.id = :category_id')
          ->setParameter('category_id', $category);
      break;
      // 태그
      case $tag:
        $query
          ->innerJoin('a.tag', 't')
          ->where('t.name = :name')
          ->setParameter('name', $tag);
      break;
      // 검색
      case $search:
        foreach($this->prepareQuery($search) as $key => $term) {
          $query
          ->orWhere('a.title LIKE :title_' . $key)
          ->orWhere('a.content LIKE :content_' . $key)
          ->setParameter('title_' . $key, '%' . trim($term) . '%')
          ->setParameter('content_' . $key, '%' . trim($term) . '%');
        }
      break;
    }

    $query
      ->andWhere('a.visible = :visible')
      ->setParameter('visible', true)
      ->orderBy('a.id', 'DESC')
      ->getQuery()
    ;
  
    return $this->paginator->paginate($query, $page, 3);
  }
  /**
   * 최근 작성한 게시물
   * @access public
   * @param int $count
   * @return array
   */
  public function recentArticles(int $count): ?array {
    return $this->createQueryBuilder('a')
      ->addOrderBy('a.updated_at', 'DESC')
      ->addOrderBy('a.created_at', 'DESC')
      ->addOrderBy('a.id', 'DESC')
      ->getQuery()
      ->setMaxResults($count)
      ->getResult();
  }

  /**
   * 검색 문자열 처리
   * @access private
   * @param string $search
   * @return array
   */
  private function prepareQuery(string $search): array {
    $terms = array_unique(explode(' ', $search));
    return array_filter($terms, function($term) {
      return 2 <= mb_strlen($term);
    }); 
  }
}
