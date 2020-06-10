<?php

namespace App\Repository;

use App\Entity\UserEmailAuth;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserEmailAuth|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserEmailAuth|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserEmailAuth[]    findAll()
 * @method UserEmailAuth[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserEmailAuthRepository extends ServiceEntityRepository {

  /**
   * @access public
   */
  public function __construct(ManagerRegistry $registry) {
    
    parent::__construct($registry, UserEmailAuth::class);
  }
}
