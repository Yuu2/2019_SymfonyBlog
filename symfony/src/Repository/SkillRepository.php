<?php

namespace App\Repository;

use App\Entity\Skill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 *
 * @author yuu2dev
 * updated 2020.01.18
 * 
 * @method Skill|null find($id, $lockMode = null, $lockVersion = null)
 * @method Skill|null findOneBy(array $criteria, array $orderBy = null)
 * @method Skill[]    findAll()
 * @method Skill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillRepository extends ServiceEntityRepository {

  /**
   * @access public
   * @param ManagerRegistry $registry
   */
  public function __construct(ManagerRegistry $registry) {
    parent::__construct($registry, Skill::class);
  }

  /**
   * @access public
   * @param int $count
   * @return array
   */
  public function countSkills(int $count): ?array {

    return $this->createQueryBuilder('s')
      ->select()
      ->andWhere('s.visible = :visible')
      ->setParameter('visible', true)
      ->getQuery()
      ->setMaxResults($count)
      ->getResult()
    ;
  }
}
