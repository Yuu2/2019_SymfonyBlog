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
   * 게시판 페이지 일람 쿼리
   * @access public
   * @param Integer $board
   * @param Integer $page
   */
  function index($board, $page) {
    return $this->createQueryBuilder('at')
      ->select('at.id, at.title, at.content, at.created_at', 'ac.username', 'b.subject')
      ->innerJoin('at.account', 'ac')
      ->innerJoin('at.board', 'b')
      ->where('at.board = :board')
      ->setParameter('board', $board)
      ->addOrderBy('at.id', 'ASC')
      ->getQuery()
      ->setFirstResult(($page * 10) - 10)
      ->setMaxResults(10)
      ->getResult();
  }

  /**
   * 게시판 페이지 카운트 쿼리
   * @access public
   * @param Integer $board
   */
  function total($board) {
    return $this->createQueryBuilder('at')
      ->select('count(at.id) as total')
      ->where('at.board = :board')
      ->setParameter('board', $board)
      ->getQuery()
      ->getOneOrNullResult();
  }

  /**
   * @access public
   * @todo 미완성
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
   * @todo 미완성
   */
  function findArticleTotal() {
    return $this->createQueryBuilder('at')
      ->select('count(at.id)')
      ->getQuery()
      ->getResult();

  }
}
