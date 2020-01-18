<?php

namespace App\Repository;

use App\Entity\Skill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 *
 * @author Yuu2
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
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry) {
      parent::__construct($registry, Skill::class);
    }

    /**
     * @access public
     * @return array
     */
    public function findAll(): ?array {
      return $this->createQueryBuilder('s')
        ->andWhere('s.visible = :visible')
        ->setParameter('visible', true)
        ->getQuery()
        ->getResult()
      ;
    }
}
