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
   * @return array
   */
  public function findAll() : ?array { 
    return $this->categoryRepository->findAll();
  }

  /**
   * 가장 최근에 정렬된 카테고리 
   * @access public
   * @param array $categories
   */
  public function getLastSortedCategory(array $categories = []) {
    
  }
}