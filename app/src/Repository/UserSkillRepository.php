<?php

namespace App\Repository;

use App\Entity\UserSkill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserSkill|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserSkill|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserSkill[]    findAll()
 * @method UserSkill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserSkillRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserSkill::class);
    }

    // /**
    //  * @return UserSkill[] Returns an array of UserSkill objects
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
    public function findOneBySomeField($value): ?UserSkill
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
