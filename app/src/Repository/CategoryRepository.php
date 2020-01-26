<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository {
  
  public function __construct(ManagerRegistry $registry) {
      parent::__construct($registry, Category::class);
  }

  /**
   * 계층 카테고리
   * @access public
   * @param int $count
   * @return array
   */
  public function categories(int $count): ?array {
    return $this->createQueryBuilder('c')
    ->getQuery()
    ->setMaxResults($count)
    ->getResult();
  }
}
