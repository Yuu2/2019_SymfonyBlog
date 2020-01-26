<?php

namespace App\Repository;

use App\Entity\Portfolio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @author Yuu2
 * updated 2020.01.18
 * 
 * @method Portfolio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Portfolio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Portfolio[]    findAll()
 * @method Portfolio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortfolioRepository extends ServiceEntityRepository {

  /**
   * @access public
   * @param ManagerRegistry $registry
   */
  public function __construct(ManagerRegistry $registry) {
      parent::__construct($registry, Portfolio::class);
  }

  /**
   * @access public
   * @return array
   */
  public function findAll(): ?array {
    return $this->createQueryBuilder('p')
      ->andWhere('p.visible = :visible')
      ->setParameter('visible', true)
      ->getQuery()
      ->getResult()
    ;
  }
}
