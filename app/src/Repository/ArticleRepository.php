<?php

namespace App\Repository;

use App\Entity\Article;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

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
   * @param RegistryInterface $registry
   * @param PaginatorInterface $paginatorInterface
   */
  public function __construct(RegistryInterface $registry, PaginatorInterface $paginator) {
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

    $page = $params['page'];
    $page = is_numeric($page) || !is_null($page) ? $page : 1;
    
    $tag = $params['tag'];
    $search = $params['search'];

    $query = $this->createQueryBuilder('a');
    
    switch(true) {
      // 검색
      case $search:
        foreach($this->prepareQuery($search) as $key => $term) {
          $query
          ->orWhere('a.title LIKE :title_' . $key)
          ->orWhere('a.title LIKE :content_' . $key)
          ->setParameter('title_' . $key, '%' . trim($term) . '%')
          ->setParameter('content_' . $key, '%' . trim($term) . '%');
        }
      break;
      // 태그
      case $tag:
        $query
          ->innerJoin('a.article_tag', 'at')
          ->innerJoin('at.tag', 't')
          ->where('t.name = :tagname')
          ->setParameter('tagname', $tag);
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
