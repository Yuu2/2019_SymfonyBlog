<?php

namespace App\Repository;

use App\Entity\Account;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Account|null find($id, $lockMode = null, $lockVersion = null)
 * @method Account|null findOneBy(array $criteria, array $orderBy = null)
 * @method Account[]    findAll()
 * @method Account[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry) {
    
      parent::__construct($registry, Account::class);
    }
    /**
     * @access public
     * @param Integer $id
     */
    function find($id) {
      return $this->createQueryBuilder('a')
                  ->select('a.username, a.email')
                  ->where('a.id = :id')
                  ->setParameter('id', $id)
                  ->getQuery()
                  ->getOneOrNullResult();
    }
}
