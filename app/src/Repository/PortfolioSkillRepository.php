<?php

namespace App\Repository;

use App\Entity\PortfolioSkill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PortfolioSkill|null find($id, $lockMode = null, $lockVersion = null)
 * @method PortfolioSkill|null findOneBy(array $criteria, array $orderBy = null)
 * @method PortfolioSkill[]    findAll()
 * @method PortfolioSkill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortfolioSkillRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PortfolioSkill::class);
    }

    // /**
    //  * @return PortfolioSkill[] Returns an array of PortfolioSkill objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PortfolioSkill
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
