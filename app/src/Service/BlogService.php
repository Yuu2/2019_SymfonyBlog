<?php

namespace App\Service;

use App\Repository\ArticleRepository;
use App\Repository\TagRepository;
/**
 * @author Yuu2
 * updated 2020.01.19
 */
class BlogService {

  /**
   * @var ArticleRepository
   */
  protected $articleRepository;
  /**
   * @var TagRepository
   */
  protected $tagRepository;

  /**
   * @access public
   * @param ArticleRepository $articleRepository
   * @param TagRepository $tagRepository
   */
  public function __construct(ArticleRepository $articleRepository, TagRepository $tagRepository) {
    $this->articleRepository = $articleRepository;
    $this->tagRepository = $tagRepository;
  }

  /**
   * @access public
   * @param array $query
   * @return Object
   */
  public function articles(array $query): ?Object {

    return $this->articleRepository->paging($query);
  }

  /**
   * @access public
   * @return array
   */
  public function tags(): ?array {
    return $this->tagRepository->findAll();
  }
}