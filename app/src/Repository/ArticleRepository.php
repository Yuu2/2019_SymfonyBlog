<?php

namespace App\Repository;

use App\Entity\Article;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository {

  /**
   * @access public
   */
  function __construct(RegistryInterface $registry) {
    parent::__construct($registry, Article::class);
  }
  /**
   * @access public
   */
  function index() {
    return $this->createQueryBuilder('at')
      ->select('at.id, at.title, at.content, at.created_at', 'ac.username', 'b.subject')
      ->innerJoin('at.account', 'ac')
      ->innerJoin('at.board', 'b')
      ->orderBy('at.created_at', 'DESC')
      ->getQuery()
      ->getResult();
  }
  /**
   * @access public
   */
  function show($id) {
    return $this->createQueryBuilder('at')
      ->select('at.id, at.title, at.content, at.created_at', 'ac.username', 'b.subject')
      ->innerJoin('at.account', 'ac')
      ->innerJoin('at.board', 'b')
      ->where('at.id = :id')
      ->setParameter('id', $id)
      ->getQuery()
      ->getResult();
  }
  /**
   * @access public
   */
  function findArticleTotal() {
    return $this->createQueryBuilder('at')
      ->select('count(at.id)')
      ->getQuery()
      ->getResult();

  }
}
