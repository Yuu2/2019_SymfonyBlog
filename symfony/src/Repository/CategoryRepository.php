<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @author yuu2dev
 * updated 2020.07.04
 * 
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository {
  
  /**
   * @access public
   */
  public function __construct(ManagerRegistry $registry) {
    parent::__construct($registry, Category::class);
  }

  /**
   * 카테고리 목록
   * @access public
   * @param bool $hasTotal
   * @return array
   */
  public function findAll(bool $hasTotal = false): ?array {

    $builder = $this->createQueryBuilder('c');
    
    if ($hasTotal) {
      $builder
        ->select('c as row, count(c.id) as total')
        ->join('c.article', 'a')
        ->groupby('c.id');
    } else {
      $builder->select('c as row');
    }

    $builder
      ->where('c.visible = :visible')
      ->setParameter('visible', true);

    /** @var array */
    $categories = $builder
      ->orderBy('c.sort_no', 'ASC')
      ->getQuery()
      ->getResult()
    ;
    
    return $categories;
  }

  /**
   * 가장 마지막 카테고리 
   * @access public
   */
  public function getLastSortedCategory() {
    $category = $this->createQueryBuilder('c')
      ->select()
      ->where('c.visible = :visible')
      ->setParameter('visible', true)
      ->orderBy('c.sort_no', 'ASC')
      ->addOrderBy('c.id', 'ASC')
      ->setMaxResults(1)
      ->getQuery()
      ->getResult()
    ;
  }
}
