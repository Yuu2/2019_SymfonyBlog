<?php

namespace App\Service;

use App\Repository\CategoryRepository;

/**
 * @author Yuu2
 * updated 2020.01.25
 */
class CategoryService {

  /**
   * @var CategoryRepository
   */
  protected $categoryRepository;

  /**
   * @access public
   * @param CategoryRepository $categoryRepository
   */
  public function __construct(CategoryRepository $categoryRepository) {
    $this->categoryRepository = $categoryRepository;
  }

  /**
   * @access public
   * @param int $count
   * @return array
   */
  public function categories(int $count = 10): ?array {

    return $this->categoryRepository->categories($count);
  }
}