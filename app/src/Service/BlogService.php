<?php

namespace App\Service;

use App\Repository\ArticleRepository;
use App\Repository\TagRepository;
use Symfony\Component\HttpFoundation\Request;

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
   * @param Request $request
   * @return Object
   */
  public function articles(Request $request): Object {

    $params = array(
      'category' => $request->get('category'),
      'page' => $request->get('page'),
      'search' => $request->get('search'),
      'tag' => $request->get('tag'),
    );

    return $this->articleRepository->paging($params);
  }
  /**
   * @access public
   * @param int $count
   * @return array
   */
  public function recentArticles(int $count = 10): ?array {

    return $this->articleRepository->recentArticles($count);
  }

  /**
   * @access public
   * @return array
   */
  public function tags(): ?array {
    return $this->tagRepository->findAll();
  }
}