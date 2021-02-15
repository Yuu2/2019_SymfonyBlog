<?php

namespace App\Repository;

use App\Entity\GuestBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GuestBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method GuestBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method GuestBook[]    findAll()
 * @method GuestBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GuestBookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GuestBook::class);
    }

    // /**
    //  * @return GuestBook[] Returns an array of GuestBook objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GuestBook
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
