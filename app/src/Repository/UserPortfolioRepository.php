<?php

namespace App\Repository;

use App\Entity\UserPortfolio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserPortfolio|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserPortfolio|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserPortfolio[]    findAll()
 * @method UserPortfolio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserPortfolioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserPortfolio::class);
    }

    // /**
    //  * @return UserPortfolio[] Returns an array of UserPortfolio objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserPortfolio
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
