<?php

namespace App\Repository;

use App\Entity\UserArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserArticle[]    findAll()
 * @method UserArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserArticle::class);
    }

    // /**
    //  * @return UserArticle[] Returns an array of UserArticle objects
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
    public function findOneBySomeField($value): ?UserArticle
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
