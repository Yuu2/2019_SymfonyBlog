<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

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
   * @return array
   */
  public function visibleCategories(): ?array {

    return $this->createQueryBuilder('c')
      ->select()
      ->andWhere('c.visible = :visible')
      ->setParameter('visible', true)
      ->orderBy('c.sort_no', 'ASC')
      ->getQuery()
      ->getResult()
    ;
  }
}
