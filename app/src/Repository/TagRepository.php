<?php

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @author Yuu2
 * updated 2020.01.19
 * 
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository {

  /**
   * @access public
   * @param RegistryInterface $registry
   */
  public function __construct(ManagerRegistry $registry) {
    parent::__construct($registry, Tag::class);
  }

  /**
   * @access public
   * @param int $count
   * @return array
   */
  public function countTags(int $count): ?array {
    return $this->createQueryBuilder('t')
      ->select()
      ->groupBy('t.name')
      ->orderBy('t.created_at', 'DESC')
      ->getQuery()
      ->setMaxResults($count)
      ->getResult()
    ;
  }
}
