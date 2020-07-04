<?php

namespace App\Service;

use App\Repository\CategoryRepository;

/**
 * @author yuu2dev
 * updated 2020.07.03
 */
class CategoryService {

  /**
   * @var CategoryRepository
   */
  private $categoryRepository;

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
  public function findCategories(int $count = 10): ?array {
    
    return $this->categoryRepository->findAll();
  }
}