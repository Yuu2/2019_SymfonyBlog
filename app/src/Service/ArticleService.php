<?php

namespace App\Service;

use App\Repository\ArticleRepository;

/**
 * @author Yuu2
 * updated 2020.01.19
 */
class ArticleService {

  /**
   * @var ArticleRepository
   */
  private $articleRepository;

  /**
   * @access public
   * @param ArticleRepository $articleRepository
   */
  public function __construct(ArticleRepository $articleRepository) {
    $this->articleRepository = $articleRepository;
  }

  /**
   * @access public
   * @param int $page
   * @return Object
   */
  public function all(?int $page): ?Object {
    
    $page = is_numeric($page) || !is_null($page) ? $page : 1;

    return $this->articleRepository->paging($page);
  }
}