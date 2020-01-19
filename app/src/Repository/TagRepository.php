<?php

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

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
  public function __construct(RegistryInterface $registry) {
    parent::__construct($registry, Tag::class);
  }

  /**
   * @access public
   * @return array
   */
  public function findAll(): ?array {
    return $this->createQueryBuilder('t')
      ->orderBy('t.id', 'DESC')
      ->getQuery()
      ->getResult()
    ;
  }
}
